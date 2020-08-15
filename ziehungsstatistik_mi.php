<?php

include('db_connection.php');

$all_sql = "SELECT Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Lottozahl6, Glueckszahl FROM swisslottozahlentabelle WHERE Ziehung = 'Mittwoch'";

$result_zh_mi = mysqli_query( $db, $all_sql);
$response_mi = array();
$posts_mi = array();

$response_mi_g = array();
$glueck_mi = array();

while ( $row = mysqli_fetch_array( $result_zh_mi, MYSQLI_NUM ) ) {
	$Lottozahl1 = $row[0];
	$Lottozahl2 = $row[1];
	$Lottozahl3 = $row[2];
	$Lottozahl4 = $row[3];
	$Lottozahl5 = $row[4];
	$Lottozahl6 = $row[5];
	$Glueckszahl= $row[6];

	$posts_mi[] = array( 'Lottozahl1' => $Lottozahl1, 'Lottozahl2' => $Lottozahl2, 'Lottozahl3' => $Lottozahl3, 'Lottozahl4' => $Lottozahl4, 'Lottozahl5' => $Lottozahl5, 'Lottozahl6' => $Lottozahl6);
    $glueck_mi[] = array('Glueckszahl' => $Glueckszahl );
}
$response_mi['posts_mi'] = $posts_mi;
$json_data_mi = json_encode( $posts_mi );
file_put_contents( 'mi_tab.json', $json_data_mi );


$response_mi_g['posts_mi_g'] = $glueck_mi;
$json_data_mi_g = json_encode( $glueck_mi );
file_put_contents( 'mi_glueck.json', $json_data_mi_g );

mysqli_close( $db );
?>
<script>

    //--------------------Lottozahlen--------------------//


    // set the dimensions and margins of the graph
    const margin_mi = {top: 10, right: 30, bottom: 40, left: 50},
        width_mi = 850 - margin_mi.left - margin_mi.right,
        height_mi = 300 - margin_mi.top - margin_mi.bottom;


    // append the svg object
    const svg_mi = d3.select("#mi_datab")
        .append("svg")
        .attr("width", width_mi + margin_mi.left + margin_mi.right)
        .attr("height", height_mi + margin_mi.top + margin_mi.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_mi.left + "," + margin_mi.top + ")");

    // text label for the x axis
    svg_mi.append("text")
        .attr("y", height_mi + margin_mi.bottom / 2)
        .attr("x", width_mi / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Lottozahlen");


    // text label for the y axis
    svg_mi.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_mi.left)
        .attr("x", 0 - (height_mi / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("mi_tab.json").then(function (data) {

        data.forEach(function (d) {
            d.Lottozahl1 = +d.Lottozahl1;
            d.Lottozahl2 = +d.Lottozahl2;
            d.Lottozahl3 = +d.Lottozahl3;
            d.Lottozahl4 = +d.Lottozahl4;
            d.Lottozahl5 = +d.Lottozahl5;
            d.Lottozahl6 = +d.Lottozahl6;
        });

        mi_arr = [];
        for (let mi = 0; mi < data.length; mi++) {
            mi_arr.push(data[mi].Lottozahl1, data[mi].Lottozahl2, data[mi].Lottozahl3, data[mi].Lottozahl4, data[mi].Lottozahl5, data[mi].Lottozahl6);
        }

        count_mi = [];
        mi_arr.forEach(function (iii) {
            count_mi[iii] = (count_mi[iii] || 0) + 1;
        });

        var maxval_mi = Math.max.apply(Math, Object.values(count_mi));

        y_arr_mi = [];
        for (let ymi = 1; ymi <= 42; ymi++) {
            y_arr_mi.push(ymi);
        }

        // create scales
        const x_mi = d3.scalePoint()
            .domain(y_arr_mi)
            .range([0, width_mi])
            .padding([1]);

        const y_mi = d3.scaleLinear()
            .domain([0, maxval_mi])
            .range([height_mi, 0]);

        // create axis
        svg_mi.append("g")
            .attr("transform", "translate(0," + height_mi + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_mi));

        svg_mi.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_mi).ticks(maxval_mi));

        // create bars
        svg_mi.selectAll("rect")
            .data(count_mi)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_mi - ((height_mi / maxval_mi) * count_mi[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_mi / (43)))-5;
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
        svg_mi.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
               return (height_mi / maxval_mi) * count_mi[i];
            })

    });


    //--------------------Glueckszahlen--------------------//

    // set the dimensions and margins of the graph
    const margin_mi_g = {top: 10, right: 30, bottom: 40, left: 50},
        width_mi_g = 300 - margin_mi_g.left - margin_mi_g.right,
        height_mi_g = 300 - margin_mi_g.top - margin_mi_g.bottom;

    // append the svg object
    const svg_mi_g = d3.select("#mi_datab_g")
        .append("svg")
        .attr("width", width_mi_g + margin_mi_g.left + margin_mi_g.right)
        .attr("height", height_mi_g + margin_mi_g.top + margin_mi_g.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_mi_g.left + "," + margin_mi_g.top + ")");

    // text label for the x axis
    svg_mi_g.append("text")
        .attr("y", height_mi_g + margin_mi_g.bottom / 2)
        .attr("x", width_mi_g / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Glückszahlen");

    // text label for the y axis
    svg_mi_g.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_mi_g.left)
        .attr("x", 0 - (height_mi_g / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("mi_glueck.json").then(function (data) {

        data.forEach(function (d) {
            d.Glueckszahl = +d.Glueckszahl;
        });

        mi_arr_g = [];
        for (let mi_g = 0; mi_g < data.length; mi_g++) {
            mi_arr_g.push(data[mi_g].Glueckszahl);
        }

        count_mi_g = [];
        mi_arr_g.forEach(function (iii_g) {
            count_mi_g[iii_g] = (count_mi_g[iii_g] || 0) + 1;
        });

        var maxval_mi_g = Math.max.apply(Math, Object.values(count_mi_g));

        y_arr_mi_g = [];
        for (let ymi_g = 1; ymi_g <= 6; ymi_g++) {
            y_arr_mi_g.push(ymi_g);
        }

        // create scales
        const x_mi_g = d3.scalePoint()
            .domain(y_arr_mi_g)
            .range([0, width_mi_g])
            .padding([1]);

        const y_mi_g = d3.scaleLinear()
            .domain([0, maxval_mi_g])
            .range([height_mi_g, 0]);

        // create axis
        svg_mi_g.append("g")
            .attr("transform", "translate(0," + height_mi_g + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_mi_g));

        svg_mi_g.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_mi_g).ticks(maxval_mi_g));

        // create bars
        svg_mi_g.selectAll("rect")
            .data(count_mi_g)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_mi_g - ((height_mi_g / maxval_mi_g) * count_mi_g[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_mi_g / (7)))-5;
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
        svg_mi_g.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_mi_g / maxval_mi_g) * count_mi_g[i];
            })

    });


</script>
