<?php

include('db_connection.php');

$all_sql = "SELECT Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Lottozahl6, Glueckszahl FROM swisslottozahlentabelle WHERE Ziehung = 'Samstag'";

$result_zh_sa = mysqli_query( $db, $all_sql);
$response_sa = array();
$posts_sa = array();

$response_sa_g = array();
$glueck_sa = array();


while ( $row = mysqli_fetch_array( $result_zh_sa , MYSQLI_NUM )) {
	$Lottozahl1 = $row[0];
	$Lottozahl2 = $row[1];
	$Lottozahl3 = $row[2];
	$Lottozahl4 = $row[3];
	$Lottozahl5 = $row[4];
	$Lottozahl6 = $row[5];
	$Glueckszahl= $row[6];

	$posts_sa[] = array( 'Lottozahl1' => $Lottozahl1, 'Lottozahl2' => $Lottozahl2, 'Lottozahl3' => $Lottozahl3, 'Lottozahl4' => $Lottozahl4, 'Lottozahl5' => $Lottozahl5, 'Lottozahl6' => $Lottozahl6 );
	$glueck_sa[] = array('Glueckszahl' => $Glueckszahl );
}
$response_sa['posts_sa'] = $posts_sa;
$json_data_sa = json_encode( $posts_sa );
file_put_contents( 'sa_tab.json', $json_data_sa );

$response_sa_g['posts_sa_g'] = $glueck_sa;
$json_data_sa_g = json_encode( $glueck_sa );
file_put_contents( 'sa_glueck.json', $json_data_sa_g );


mysqli_close( $db );
?>
<script>

    //--------------------Lottozahlen--------------------//


    // set the dimensions and margins of the graph
    const margin_sa = {top: 10, right: 30, bottom: 40, left: 50},
        width_sa = 850 - margin_sa.left - margin_sa.right,
        height_sa = 300 - margin_sa.top - margin_sa.bottom;


    // append the svg object
    const svg_sa = d3.select("#sa_datab")
        .append("svg")
        .attr("width", width_sa + margin_sa.left + margin_sa.right)
        .attr("height", height_sa + margin_sa.top + margin_sa.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_sa.left + "," + margin_sa.top + ")");

    // text label for the x axis
    svg_sa.append("text")
        .attr("y", height_sa + margin_sa.bottom / 2)
        .attr("x", width_sa / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Lottozahlen");


    // text label for the y axis
    svg_sa.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_sa.left)
        .attr("x", 0 - (height_sa / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("sa_tab.json").then(function (data) {

        data.forEach(function (d) {
            d.Lottozahl1 = +d.Lottozahl1;
            d.Lottozahl2 = +d.Lottozahl2;
            d.Lottozahl3 = +d.Lottozahl3;
            d.Lottozahl4 = +d.Lottozahl4;
            d.Lottozahl5 = +d.Lottozahl5;
            d.Lottozahl6 = +d.Lottozahl6;
        });

        sa_arr = [];
        for (let sa = 0; sa < data.length; sa++) {
            sa_arr.push(data[sa].Lottozahl1, data[sa].Lottozahl2, data[sa].Lottozahl3, data[sa].Lottozahl4, data[sa].Lottozahl5, data[sa].Lottozahl6);
        }

        count_sa = [];
        sa_arr.forEach(function (iii) {
            count_sa[iii] = (count_sa[iii] || 0) + 1;
        });

        var maxval_sa = Math.max.apply(Math, Object.values(count_sa));

        y_arr_sa = [];
        for (let ysa = 1; ysa <= 42; ysa++) {
            y_arr_sa.push(ysa);
        }

        // create scales
        const x_sa = d3.scalePoint()
            .domain(y_arr_sa)
            .range([0, width_sa])
            .padding([1]);

        const y_sa = d3.scaleLinear()
            .domain([0, maxval_sa])
            .range([height_sa, 0]);

        // create axis
        svg_sa.append("g")
            .attr("transform", "translate(0," + height_sa + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_sa));

        svg_sa.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_sa).ticks(maxval_sa));

        // create bars
        svg_sa.selectAll("rect")
            .data(count_sa)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_sa - ((height_sa / maxval_sa) * count_sa[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_sa / (43)))-5;
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
        svg_sa.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_sa / maxval_sa) * count_sa[i];
            })

    });



    //--------------------Glueckszahlen--------------------//

    // set the dimensions and margins of the graph
    const margin_sa_g = {top: 10, right: 30, bottom: 40, left: 50},
        width_sa_g = 300 - margin_sa_g.left - margin_sa_g.right,
        height_sa_g = 300 - margin_sa_g.top - margin_sa_g.bottom;

    // append the svg object
    const svg_sa_g = d3.select("#sa_datab_g")
        .append("svg")
        .attr("width", width_sa_g + margin_sa_g.left + margin_sa_g.right)
        .attr("height", height_sa_g + margin_sa_g.top + margin_sa_g.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_sa_g.left + "," + margin_sa_g.top + ")");

    // text label for the x axis
    svg_sa_g.append("text")
        .attr("y", height_sa_g + margin_sa_g.bottom / 2)
        .attr("x", width_sa_g / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Glückszahlen");

    // text label for the y axis
    svg_sa_g.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_sa_g.left)
        .attr("x", 0 - (height_sa_g / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("sa_glueck.json").then(function (data) {

        data.forEach(function (d) {
            d.Glueckszahl = +d.Glueckszahl;
        });

        sa_arr_g = [];
        for (let sa_g = 0; sa_g < data.length; sa_g++) {
            sa_arr_g.push(data[sa_g].Glueckszahl);
        }

        count_sa_g = [];
        sa_arr_g.forEach(function (iii_g) {
            count_sa_g[iii_g] = (count_sa_g[iii_g] || 0) + 1;
        });

        var maxval_sa_g = Math.max.apply(Math, Object.values(count_sa_g));

        y_arr_sa_g = [];
        for (let ysa_g = 1; ysa_g <= 6; ysa_g++) {
            y_arr_sa_g.push(ysa_g);
        }

        // create scales
        const x_sa_g = d3.scalePoint()
            .domain(y_arr_sa_g)
            .range([0, width_sa_g])
            .padding([1]);

        const y_sa_g = d3.scaleLinear()
            .domain([0, maxval_sa_g])
            .range([height_sa_g, 0]);

        // create axis
        svg_sa_g.append("g")
            .attr("transform", "translate(0," + height_sa_g + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_sa_g));

        svg_sa_g.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_sa_g).ticks(maxval_sa_g));

        // create bars
        svg_sa_g.selectAll("rect")
            .data(count_sa_g)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_sa_g - ((height_sa_g / maxval_sa_g) * count_sa_g[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_sa_g / (7)))-5;
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
        svg_sa_g.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_sa_g / maxval_sa_g) * count_sa_g[i];
            })

    });

</script>
