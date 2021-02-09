<?php

include('db_connection.php');

$all_sql = "SELECT Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Glueckszahl1, Glueckszahl2 FROM euromillionszahlentabelle";

$result_zh_di_fr = mysqli_query( $db, $all_sql);
$response_di_fr = array();
$posts_di_fr = array();

$response_di_fr_g = array();
$glueck_di_fr = array();

while ( $row = mysqli_fetch_array( $result_zh_di_fr, MYSQLI_NUM ) ) {
	$Lottozahl1 = $row[0];
	$Lottozahl2 = $row[1];
	$Lottozahl3 = $row[2];
	$Lottozahl4 = $row[3];
	$Lottozahl5 = $row[4];
	$Glueckszahl1 = $row[5];
	$Glueckszahl2 = $row[6];

	$posts_di_fr[] = array( 'Lottozahl1' => $Lottozahl1, 'Lottozahl2' => $Lottozahl2, 'Lottozahl3' => $Lottozahl3, 'Lottozahl4' => $Lottozahl4, 'Lottozahl5' => $Lottozahl5);
    $glueck_di_fr[] = array('Glueckszahl1' => $Glueckszahl1, 'Glueckszahl2' => $Glueckszahl2);
}
$response_di_fr['posts_di_fr'] = $posts_di_fr;
$json_data_di_fr = json_encode( $posts_di_fr );
file_put_contents( 'di_fr_tab.json', $json_data_di_fr );


$response_di_fr_g['posts_di_fr_g'] = $glueck_di_fr;
$json_data_di_fr_g = json_encode( $glueck_di_fr );
file_put_contents( 'di_fr_glueck.json', $json_data_di_fr_g );

mysqli_close( $db );
?>
<script>

    //--------------------Lottozahlen--------------------//


    // set the dimensions and margins of the graph
    const margin_di_fr = {top: 10, right: 30, bottom: 40, left: 50},
        width_di_fr = 850 - margin_di_fr.left - margin_di_fr.right,
        height_di_fr = 300 - margin_di_fr.top - margin_di_fr.bottom;


    // append the svg object
    const svg_di_fr = d3.select("#di_fr_datab")
        .append("svg")
        .attr("width", width_di_fr + margin_di_fr.left + margin_di_fr.right)
        .attr("height", height_di_fr + margin_di_fr.top + margin_di_fr.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_di_fr.left + "," + margin_di_fr.top + ")");

    // text label for the x axis
    svg_di_fr.append("text")
        .attr("y", height_di_fr + margin_di_fr.bottom / 2)
        .attr("x", width_di_fr / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Lottozahlen");


    // text label for the y axis
    svg_di_fr.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_di_fr.left)
        .attr("x", 0 - (height_di_fr / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("di_fr_tab.json").then(function (data) {

        data.forEach(function (d) {
            d.Lottozahl1 = +d.Lottozahl1;
            d.Lottozahl2 = +d.Lottozahl2;
            d.Lottozahl3 = +d.Lottozahl3;
            d.Lottozahl4 = +d.Lottozahl4;
            d.Lottozahl5 = +d.Lottozahl5;
        });

        di_fr_arr = [];
        for (let di_fr = 0; di_fr < data.length; di_fr++) {
            di_fr_arr.push(data[di_fr].Lottozahl1, data[di_fr].Lottozahl2, data[di_fr].Lottozahl3, data[di_fr].Lottozahl4, data[di_fr].Lottozahl5);
        }

        count_di_fr = [];
        di_fr_arr.forEach(function (iii) {
            count_di_fr[iii] = (count_di_fr[iii] || 0) + 1;
        });

        var maxval_di_fr = Math.max.apply(Math, Object.values(count_di_fr));

        y_arr_di_fr = [];
        for (let ydifr = 1; ydifr <= 50; ydifr++) {
            y_arr_di_fr.push(ydifr);
        }

        // create scales
        const x_di_fr = d3.scalePoint()
            .domain(y_arr_di_fr)
            .range([0, width_di_fr])
            .padding([1]);

        const y_di_fr = d3.scaleLinear()
            .domain([0, maxval_di_fr])
            .range([height_di_fr, 0]);

        // create axis
        svg_di_fr.append("g")
            .attr("transform", "translate(0," + height_di_fr + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_di_fr));

        svg_di_fr.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_di_fr).ticks(maxval_di_fr));

        // create bars
        svg_di_fr.selectAll("rect")
            .data(count_di_fr)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_di_fr - ((height_di_fr / maxval_di_fr) * count_di_fr[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_di_fr / (51)))-5;
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
        svg_di_fr.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
               return (height_di_fr / maxval_di_fr) * count_di_fr[i];
            })

    });


    //--------------------Glueckszahlen--------------------//

    // set the dimensions and margins of the graph
    const margin_di_fr_g = {top: 10, right: 30, bottom: 40, left: 50},
        width_di_fr_g = 300 - margin_di_fr_g.left - margin_di_fr_g.right,
        height_di_fr_g = 300 - margin_di_fr_g.top - margin_di_fr_g.bottom;

    // append the svg object
    const svg_di_fr_g = d3.select("#di_fr_datab_g")
        .append("svg")
        .attr("width", width_di_fr_g + margin_di_fr_g.left + margin_di_fr_g.right)
        .attr("height", height_di_fr_g + margin_di_fr_g.top + margin_di_fr_g.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_di_fr_g.left + "," + margin_di_fr_g.top + ")");

    // text label for the x axis
    svg_di_fr_g.append("text")
        .attr("y", height_di_fr_g + margin_di_fr_g.bottom / 2)
        .attr("x", width_di_fr_g / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Glückszahlen");

    // text label for the y axis
    svg_di_fr_g.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_di_fr_g.left)
        .attr("x", 0 - (height_di_fr_g / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("di_fr_glueck.json").then(function (data) {

        data.forEach(function (d) {
            d.Glueckszahl1 = +d.Glueckszahl1;
            d.Glueckszahl2 = +d.Glueckszahl2;
        });

        di_fr_arr_g = [];
        for (let di_fr_g = 0; di_fr_g < data.length; di_fr_g++) {
            di_fr_arr_g.push(data[di_fr_g].Glueckszahl1);
            di_fr_arr_g.push(data[di_fr_g].Glueckszahl2);
        }

        count_di_fr_g = [];
        di_fr_arr_g.forEach(function (iii_g) {
            count_di_fr_g[iii_g] = (count_di_fr_g[iii_g] || 0) + 1;
        });

        var maxval_di_fr_g = Math.max.apply(Math, Object.values(count_di_fr_g));

        y_arr_di_fr_g = [];
        for (let ydi_fr_g = 1; ydi_fr_g <= 12; ydi_fr_g++) {
            y_arr_di_fr_g.push(ydi_fr_g);
        }

        // create scales
        const x_di_fr_g = d3.scalePoint()
            .domain(y_arr_di_fr_g)
            .range([0, width_di_fr_g])
            .padding([1]);

        const y_di_fr_g = d3.scaleLinear()
            .domain([0, maxval_di_fr_g])
            .range([height_di_fr_g, 0]);

        // create axis
        svg_di_fr_g.append("g")
            .attr("transform", "translate(0," + height_di_fr_g + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_di_fr_g));

        svg_di_fr_g.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_di_fr_g).ticks(maxval_di_fr_g));

        // create bars
        svg_di_fr_g.selectAll("rect")
            .data(count_di_fr_g)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_di_fr_g - ((height_di_fr_g / maxval_di_fr_g) * count_di_fr_g[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_di_fr_g / (13)))-5;
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
        svg_di_fr_g.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_di_fr_g / maxval_di_fr_g) * count_di_fr_g[i];
            })

    });


</script>
