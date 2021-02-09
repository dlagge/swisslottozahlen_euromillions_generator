<?php

include('db_connection.php');

$all_sql = "SELECT Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Glueckszahl1, Glueckszahl2 FROM euromillionszahlentabelle WHERE Ziehung = 'Freitag'";

$result_zh_fr = mysqli_query( $db, $all_sql);
$response_fr = array();
$posts_fr = array();

$response_fr_g = array();
$glueck_fr = array();

while ( $row = mysqli_fetch_array( $result_zh_fr, MYSQLI_NUM ) ) {
	$Lottozahl1 = $row[0];
	$Lottozahl2 = $row[1];
	$Lottozahl3 = $row[2];
	$Lottozahl4 = $row[3];
	$Lottozahl5 = $row[4];
	$Glueckszahl1 = $row[5];
	$Glueckszahl2 = $row[6];

	$posts_fr[] = array( 'Lottozahl1' => $Lottozahl1, 'Lottozahl2' => $Lottozahl2, 'Lottozahl3' => $Lottozahl3, 'Lottozahl4' => $Lottozahl4, 'Lottozahl5' => $Lottozahl5);
    $glueck_fr[] = array('Glueckszahl1' => $Glueckszahl1, 'Glueckszahl2' => $Glueckszahl2);
}
$response_fr['posts_fr'] = $posts_fr;
$json_data_fr = json_encode( $posts_fr );
file_put_contents( 'fr_tab.json', $json_data_fr );


$response_fr_g['posts_fr_g'] = $glueck_fr;
$json_data_fr_g = json_encode( $glueck_fr );
file_put_contents( 'fr_glueck.json', $json_data_fr_g );

mysqli_close( $db );
?>
<script>

    //--------------------Lottozahlen--------------------//


    // set the dimensions and margins of the graph
    const margin_fr = {top: 10, right: 30, bottom: 40, left: 50},
        width_fr = 850 - margin_fr.left - margin_fr.right,
        height_fr = 300 - margin_fr.top - margin_fr.bottom;


    // append the svg object
    const svg_fr = d3.select("#fr_datab")
        .append("svg")
        .attr("width", width_fr + margin_fr.left + margin_fr.right)
        .attr("height", height_fr + margin_fr.top + margin_fr.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_fr.left + "," + margin_fr.top + ")");

    // text label for the x axis
    svg_fr.append("text")
        .attr("y", height_fr + margin_fr.bottom / 2)
        .attr("x", width_fr / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Lottozahlen");


    // text label for the y axis
    svg_fr.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_fr.left)
        .attr("x", 0 - (height_fr / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("fr_tab.json").then(function (data) {

        data.forEach(function (d) {
            d.Lottozahl1 = +d.Lottozahl1;
            d.Lottozahl2 = +d.Lottozahl2;
            d.Lottozahl3 = +d.Lottozahl3;
            d.Lottozahl4 = +d.Lottozahl4;
            d.Lottozahl5 = +d.Lottozahl5;
        });

        fr_arr = [];
        for (let fr = 0; fr < data.length; fr++) {
            fr_arr.push(data[fr].Lottozahl1, data[fr].Lottozahl2, data[fr].Lottozahl3, data[fr].Lottozahl4, data[fr].Lottozahl5);
        }

        count_fr = [];
        fr_arr.forEach(function (iii) {
            count_fr[iii] = (count_fr[iii] || 0) + 1;
        });

        var maxval_fr = Math.max.apply(Math, Object.values(count_fr));

        y_arr_fr = [];
        for (let yfr = 1; yfr <= 50; yfr++) {
            y_arr_fr.push(yfr);
        }

        // create scales
        const x_fr = d3.scalePoint()
            .domain(y_arr_fr)
            .range([0, width_fr])
            .padding([1]);

        const y_fr = d3.scaleLinear()
            .domain([0, maxval_fr])
            .range([height_fr, 0]);

        // create axis
        svg_fr.append("g")
            .attr("transform", "translate(0," + height_fr + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_fr));

        svg_fr.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_fr).ticks(maxval_fr));

        // create bars
        svg_fr.selectAll("rect")
            .data(count_fr)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_fr - ((height_fr / maxval_fr) * count_fr[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_fr / (51)))-5;
            })
            .attr("height", 0)
            .attr("fill", function () {
                return "#DB5353";
            })
            .on("mousemove", function () {
                d3.select(this).style("fill", "white");
            })
            .on("mouseout", function () {
                d3.select(this).style("fill", "#DB5353");
            });

        // animating the bars
        svg_fr.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
               return (height_fr / maxval_fr) * count_fr[i];
            })

    });


    //--------------------Glueckszahlen--------------------//

    // set the dimensions and margins of the graph
    const margin_fr_g = {top: 10, right: 30, bottom: 40, left: 50},
        width_fr_g = 300 - margin_fr_g.left - margin_fr_g.right,
        height_fr_g = 300 - margin_fr_g.top - margin_fr_g.bottom;

    // append the svg object
    const svg_fr_g = d3.select("#fr_datab_g")
        .append("svg")
        .attr("width", width_fr_g + margin_fr_g.left + margin_fr_g.right)
        .attr("height", height_fr_g + margin_fr_g.top + margin_fr_g.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_fr_g.left + "," + margin_fr_g.top + ")");

    // text label for the x axis
    svg_fr_g.append("text")
        .attr("y", height_fr_g + margin_fr_g.bottom / 2)
        .attr("x", width_fr_g / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Glückszahlen");

    // text label for the y axis
    svg_fr_g.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_fr_g.left)
        .attr("x", 0 - (height_fr_g / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("fr_glueck.json").then(function (data) {

        data.forEach(function (d) {
            d.Glueckszahl1 = +d.Glueckszahl1;
            d.Glueckszahl2 = +d.Glueckszahl2;
        });

        fr_arr_g = [];
        for (let fr_g = 0; fr_g < data.length; fr_g++) {
            fr_arr_g.push(data[fr_g].Glueckszahl1);
            fr_arr_g.push(data[fr_g].Glueckszahl2);
        }

        count_fr_g = [];
        fr_arr_g.forEach(function (iii_g) {
            count_fr_g[iii_g] = (count_fr_g[iii_g] || 0) + 1;
        });

        var maxval_fr_g = Math.max.apply(Math, Object.values(count_fr_g));

        y_arr_fr_g = [];
        for (let yfr_g = 1; yfr_g <= 12; yfr_g++) {
            y_arr_fr_g.push(yfr_g);
        }

        // create scales
        const x_fr_g = d3.scalePoint()
            .domain(y_arr_fr_g)
            .range([0, width_fr_g])
            .padding([1]);

        const y_fr_g = d3.scaleLinear()
            .domain([0, maxval_fr_g])
            .range([height_fr_g, 0]);

        // create axis
        svg_fr_g.append("g")
            .attr("transform", "translate(0," + height_fr_g + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_fr_g));

        svg_fr_g.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_fr_g).ticks(maxval_fr_g));

        // create bars
        svg_fr_g.selectAll("rect")
            .data(count_fr_g)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_fr_g - ((height_fr_g / maxval_fr_g) * count_fr_g[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_fr_g / (13)))-5;
            })
            .attr("height", 0)
            .attr("fill", function () {
                return "yellow";
            })
            .on("mousemove", function () {
                d3.select(this).style("fill", "white");
            })
            .on("mouseout", function () {
                d3.select(this).style("fill", "yellow");
            });


        // animating the bars
        svg_fr_g.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_fr_g / maxval_fr_g) * count_fr_g[i];
            })

    });


</script>
