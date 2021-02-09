<?php

include('db_connection.php');

$all_sql = "SELECT Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Lottozahl6, Glueckszahl FROM swisslottozahlentabelle";

$result_zh_mi_sa = mysqli_query( $db, $all_sql);
$response_mi_sa = array();
$posts_mi_sa = array();

$response_mi_sa_g = array();
$glueck_mi_sa = array();


while ( $row = mysqli_fetch_array( $result_zh_mi_sa , MYSQLI_NUM )) {
	$Lottozahl1 = $row[0];
	$Lottozahl2 = $row[1];
	$Lottozahl3 = $row[2];
	$Lottozahl4 = $row[3];
	$Lottozahl5 = $row[4];
	$Lottozahl6 = $row[5];
	$Glueckszahl= $row[6];

	$posts_mi_sa[] = array( 'Lottozahl1' => $Lottozahl1, 'Lottozahl2' => $Lottozahl2, 'Lottozahl3' => $Lottozahl3, 'Lottozahl4' => $Lottozahl4, 'Lottozahl5' => $Lottozahl5, 'Lottozahl6' => $Lottozahl6 );
	$glueck_mi_sa[] = array('Glueckszahl' => $Glueckszahl );
}
$response_mi_sa['posts_mi_sa'] = $posts_mi_sa;
$json_data_mi_sa = json_encode( $posts_mi_sa );
file_put_contents( 'mi_sa_tab.json', $json_data_mi_sa );

$response_mi_sa_g['posts_mi_sa_g'] = $glueck_mi_sa;
$json_data_mi_sa_g = json_encode( $glueck_mi_sa );
file_put_contents( 'mi_sa_glueck.json', $json_data_mi_sa_g );


mysqli_close( $db );
?>
<script>

    //--------------------Lottozahlen--------------------//


    // set the dimensions and margins of the graph
    const margin_mi_sa = {top: 10, right: 30, bottom: 40, left: 50},
        width_mi_sa = 850 - margin_mi_sa.left - margin_mi_sa.right,
        height_mi_sa = 300 - margin_mi_sa.top - margin_mi_sa.bottom;


    // append the svg object
    const svg_mi_sa = d3.select("#mi_sa_datab")
        .append("svg")
        .attr("width", width_mi_sa + margin_mi_sa.left + margin_mi_sa.right)
        .attr("height", height_mi_sa + margin_mi_sa.top + margin_mi_sa.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_mi_sa.left + "," + margin_mi_sa.top + ")");

    // text label for the x axis
    svg_mi_sa.append("text")
        .attr("y", height_mi_sa + margin_mi_sa.bottom / 2)
        .attr("x", width_mi_sa / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Lottozahlen");


    // text label for the y axis
    svg_mi_sa.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_mi_sa.left)
        .attr("x", 0 - (height_mi_sa / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("mi_sa_tab.json").then(function (data) {

        data.forEach(function (d) {
            d.Lottozahl1 = +d.Lottozahl1;
            d.Lottozahl2 = +d.Lottozahl2;
            d.Lottozahl3 = +d.Lottozahl3;
            d.Lottozahl4 = +d.Lottozahl4;
            d.Lottozahl5 = +d.Lottozahl5;
            d.Lottozahl6 = +d.Lottozahl6;
        });

        mi_sa_arr = [];
        for (let mi_sa = 0; mi_sa < data.length; mi_sa++) {
            mi_sa_arr.push(data[mi_sa].Lottozahl1, data[mi_sa].Lottozahl2, data[mi_sa].Lottozahl3, data[mi_sa].Lottozahl4, data[mi_sa].Lottozahl5, data[mi_sa].Lottozahl6);
        }

        count_mi_sa = [];
        mi_sa_arr.forEach(function (iii) {
            count_mi_sa[iii] = (count_mi_sa[iii] || 0) + 1;
        });

        var maxval_mi_sa = Math.max.apply(Math, Object.values(count_mi_sa));

        y_arr_mi_sa = [];
        for (let ymisa = 1; ymisa <= 42; ymisa++) {
            y_arr_mi_sa.push(ymisa);
        }

        // create scales
        const x_mi_sa = d3.scalePoint()
            .domain(y_arr_mi_sa)
            .range([0, width_mi_sa])
            .padding([1]);

        const y_mi_sa = d3.scaleLinear()
            .domain([0, maxval_mi_sa])
            .range([height_mi_sa, 0]);

        // create axis
        svg_mi_sa.append("g")
            .attr("transform", "translate(0," + height_mi_sa + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_mi_sa));

        svg_mi_sa.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_mi_sa).ticks(maxval_mi_sa));

        // create bars
        svg_mi_sa.selectAll("rect")
            .data(count_mi_sa)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_mi_sa - ((height_mi_sa / maxval_mi_sa) * count_mi_sa[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_mi_sa / (43)))-5;
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
        svg_mi_sa.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_mi_sa / maxval_mi_sa) * count_mi_sa[i];
            })

    });



    //--------------------Glueckszahlen--------------------//

    // set the dimensions and margins of the graph
    const margin_mi_sa_g = {top: 10, right: 30, bottom: 40, left: 50},
        width_mi_sa_g = 300 - margin_mi_sa_g.left - margin_mi_sa_g.right,
        height_mi_sa_g = 300 - margin_mi_sa_g.top - margin_mi_sa_g.bottom;

    // append the svg object
    const svg_mi_sa_g = d3.select("#mi_sa_datab_g")
        .append("svg")
        .attr("width", width_mi_sa_g + margin_mi_sa_g.left + margin_mi_sa_g.right)
        .attr("height", height_mi_sa_g + margin_mi_sa_g.top + margin_mi_sa_g.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin_mi_sa_g.left + "," + margin_mi_sa_g.top + ")");

    // text label for the x axis
    svg_mi_sa_g.append("text")
        .attr("y", height_mi_sa_g + margin_mi_sa_g.bottom / 2)
        .attr("x", width_mi_sa_g / 2)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Glückszahlen");

    // text label for the y axis
    svg_mi_sa_g.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin_mi_sa_g.left)
        .attr("x", 0 - (height_mi_sa_g / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .style("font-family", "Arial")
        .style("color", "#1a2c3f")
        .text("Anzahl Ziehungen");

    // load the data
    d3.json("mi_sa_glueck.json").then(function (data) {

        data.forEach(function (d) {
            d.Glueckszahl = +d.Glueckszahl;
        });

        mi_sa_arr_g = [];
        for (let mi_sa_g = 0; mi_sa_g < data.length; mi_sa_g++) {
            mi_sa_arr_g.push(data[mi_sa_g].Glueckszahl);
        }

        count_mi_sa_g = [];
        mi_sa_arr_g.forEach(function (iii_g) {
            count_mi_sa_g[iii_g] = (count_mi_sa_g[iii_g] || 0) + 1;
        });

        var maxval_mi_sa_g = Math.max.apply(Math, Object.values(count_mi_sa_g));

        y_arr_mi_sa_g = [];
        for (let ymisa_g = 1; ymisa_g <= 6; ymisa_g++) {
            y_arr_mi_sa_g.push(ymisa_g);
        }

        // create scales
        const x_mi_sa_g = d3.scalePoint()
            .domain(y_arr_mi_sa_g)
            .range([0, width_mi_sa_g])
            .padding([1]);

        const y_mi_sa_g = d3.scaleLinear()
            .domain([0, maxval_mi_sa_g])
            .range([height_mi_sa_g, 0]);

        // create axis
        svg_mi_sa_g.append("g")
            .attr("transform", "translate(0," + height_mi_sa_g + ")")
            .style("color", "#1a2c3f")
            .call(d3.axisBottom(x_mi_sa_g));

        svg_mi_sa_g.append("g")
            .style("color", "#1a2c3f")
            .call(d3.axisLeft(y_mi_sa_g).ticks(maxval_mi_sa_g));

        // create bars
        svg_mi_sa_g.selectAll("rect")
            .data(count_mi_sa_g)
            .enter()
            .append("rect")
            .attr("y", function (d, i) {
                return height_mi_sa_g - ((height_mi_sa_g / maxval_mi_sa_g) * count_mi_sa_g[i]);
            })
            .attr("width", 10)
            .attr("x", function (d, i) {
                return (i * (width_mi_sa_g / (7)))-5;
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
        svg_mi_sa_g.selectAll("rect")
            .transition()
            .duration(700)
            .attr("height", function (d, i) {
                return (height_mi_sa_g / maxval_mi_sa_g) * count_mi_sa_g[i];
            })

    });

</script>
