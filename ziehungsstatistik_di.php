<?php

include('db_connection.php');

$all_sql = "SELECT Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Glueckszahl1, Glueckszahl2 FROM euromillionszahlentabelle WHERE Ziehung = 'Dienstag'";

$result_zh_di = mysqli_query( $db, $all_sql);
$response_di = array();
$posts_di = array();

$response_di_g = array();
$glueck_di = array();

while ( $row = mysqli_fetch_array( $result_zh_di, MYSQLI_NUM ) ) {
	$Lottozahl1 = $row[0];
	$Lottozahl2 = $row[1];
	$Lottozahl3 = $row[2];
	$Lottozahl4 = $row[3];
	$Lottozahl5 = $row[4];
	$Glueckszahl1 = $row[5];
	$Glueckszahl2 = $row[6];

	$posts_di[] = array( 'Lottozahl1' => $Lottozahl1, 'Lottozahl2' => $Lottozahl2, 'Lottozahl3' => $Lottozahl3, 'Lottozahl4' => $Lottozahl4, 'Lottozahl5' => $Lottozahl5);
    $glueck_di[] = array('Glueckszahl1' => $Glueckszahl1, 'Glueckszahl2' => $Glueckszahl2);
}
$response_di['posts_di'] = $posts_di;
$json_data_di = json_encode( $posts_di );
file_put_contents( 'di_tab.json', $json_data_di );


$response_di_g['posts_di_g'] = $glueck_di;
$json_data_di_g = json_encode( $glueck_di );
file_put_contents( 'di_glueck.json', $json_data_di_g );

mysqli_close( $db );
?>
<script>

    //--------------------Lottozahlen--------------------//


    // set the dimensions and margins of the graph
    const margin_di = {top: 10, right: 30, bottom: 40, left: 50},
        width_di = 850 - margin_di.left - margin_di.right,
        height_di = 300 - margin_di.top - margin_di.bottom;


    // append the svg object
    const svg_di = d3.select("#di_datab")
        .append("svg")
        .attr("width", width_di + margin_di.left + margin_di.right)
        .attr("height", height_di + margin_di.top + margin_di.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_di.left + "," + margin_di.top + ")");

    // text label for the x axis
    svg_di.append("text")
        .attr("y", height_di + margin_di.bottom / 2)
        .attr("x", width_di / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Lottozahlen");


    // text label for the y axis
    svg_di.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_di.left)
        .attr("x", 0 - (height_di / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("di_tab.json").then(function (data) {

        data.forEach(function (d) {
            d.Lottozahl1 = +d.Lottozahl1;
            d.Lottozahl2 = +d.Lottozahl2;
            d.Lottozahl3 = +d.Lottozahl3;
            d.Lottozahl4 = +d.Lottozahl4;
            d.Lottozahl5 = +d.Lottozahl5;
        });

        di_arr = [];
        for (let di = 0; di < data.length; di++) {
            di_arr.push(data[di].Lottozahl1, data[di].Lottozahl2, data[di].Lottozahl3, data[di].Lottozahl4, data[di].Lottozahl5);
        }

        count_di = [];
        di_arr.forEach(function (iii) {
            count_di[iii] = (count_di[iii] || 0) + 1;
        });

        var maxval_di = Math.max.apply(Math, Object.values(count_di));

        y_arr_di = [];
        for (let ydi = 1; ydi <= 50; ydi++) {
            y_arr_di.push(ydi);
        }

        // create scales
        const x_di = d3.scalePoint()
            .domain(y_arr_di)
            .range([0, width_di])
            .padding([1]);

        const y_di = d3.scaleLinear()
            .domain([0, maxval_di])
            .range([height_di, 0]);

        // create axis
        svg_di.append("g")
            .attr("transform", "translate(0," + height_di + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_di));

        svg_di.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_di).ticks(maxval_di));

        // create bars
        svg_di.selectAll("rect")
            .data(count_di)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_di - ((height_di / maxval_di) * count_di[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_di / (51)))-5;
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
        svg_di.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
               return (height_di / maxval_di) * count_di[i];
            })

    });


    //--------------------Glueckszahlen--------------------//

    // set the dimensions and margins of the graph
    const margin_di_g = {top: 10, right: 30, bottom: 40, left: 50},
        width_di_g = 300 - margin_di_g.left - margin_di_g.right,
        height_di_g = 300 - margin_di_g.top - margin_di_g.bottom;

    // append the svg object
    const svg_di_g = d3.select("#di_datab_g")
        .append("svg")
        .attr("width", width_di_g + margin_di_g.left + margin_di_g.right)
        .attr("height", height_di_g + margin_di_g.top + margin_di_g.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_di_g.left + "," + margin_di_g.top + ")");

    // text label for the x axis
    svg_di_g.append("text")
        .attr("y", height_di_g + margin_di_g.bottom / 2)
        .attr("x", width_di_g / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Glückszahlen");

    // text label for the y axis
    svg_di_g.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_di_g.left)
        .attr("x", 0 - (height_di_g / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("di_glueck.json").then(function (data) {

        data.forEach(function (d) {
            d.Glueckszahl1 = +d.Glueckszahl1;
            d.Glueckszahl2 = +d.Glueckszahl2;
        });

        di_arr_g = [];
        for (let di_g = 0; di_g < data.length; di_g++) {
            di_arr_g.push(data[di_g].Glueckszahl1);
            di_arr_g.push(data[di_g].Glueckszahl2);
        }

        count_di_g = [];
        di_arr_g.forEach(function (iii_g) {
            count_di_g[iii_g] = (count_di_g[iii_g] || 0) + 1;
        });

        var maxval_di_g = Math.max.apply(Math, Object.values(count_di_g));

        y_arr_di_g = [];
        for (let ydi_g = 1; ydi_g <= 12; ydi_g++) {
            y_arr_di_g.push(ydi_g);
        }

        // create scales
        const x_di_g = d3.scalePoint()
            .domain(y_arr_di_g)
            .range([0, width_di_g])
            .padding([1]);

        const y_di_g = d3.scaleLinear()
            .domain([0, maxval_di_g])
            .range([height_di_g, 0]);

        // create axis
        svg_di_g.append("g")
            .attr("transform", "translate(0," + height_di_g + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_di_g));

        svg_di_g.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_di_g).ticks(maxval_di_g));

        // create bars
        svg_di_g.selectAll("rect")
            .data(count_di_g)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_di_g - ((height_di_g / maxval_di_g) * count_di_g[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_di_g / (13)))-5;
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
        svg_di_g.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_di_g / maxval_di_g) * count_di_g[i];
            })

    });


</script>
