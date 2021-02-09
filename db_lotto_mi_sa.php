<?php

include('db_connection.php');

$sql_all = "SELECT * FROM swisslottozahlentabelle ORDER BY Datum DESC ";
$result_mi_sa = mysqli_query($db,$sql_all);

echo "<table id='mi_sa_table'>";
while($row = mysqli_fetch_array($result_mi_sa, MYSQLI_NUM)){
	$da = date("d.m.Y", strtotime($row[1]));
	echo "<tr id='$row[0]'>";
	echo "<form method='post'>";
	echo "</form>";
	if($row[9] == "Mittwoch"){
	    echo "<td style='width:80px; font-size:14px; font-family:Arial;background: white; color: #1a2c3f;}'>Mi</td>";
	} else {
	    echo "<td style='width:80px; font-size:14px; font-family:Arial;background: white; color: #1a2c3f;}'>Sa</td>";
	}
	echo "<td id='$row[0]_mi_sa_date' style='width:80px; font-size:14px; font-family:Arial;background: white; color: #1a2c3f;}' onmouseover='shownumbers_mi_sa($row[0]);' onmouseout='mouseoutfunc_mi_sa($row[0]);'>". $da ."</td>";
	for($ll=1; $ll <= 42; $ll++){
		$background = "white";
		$color = "#1a2c3f";
		$fontWeight = "";
		for($lll=2; $lll<8; $lll++){
			if($row[$lll] === strval($ll)){
				$background = "#1979a9";
			}
		}
		if($row[8] === strval($ll)){
			$color = "#DB5353";
			$fontWeight = "bold";
		}
		echo "<td style='width:20px; font-size:14px; font-family:Arial;background: $background; color: $color;font-weight:$fontWeight;'>". $ll ."</td>";
	}
	echo "</tr>";
}

echo "</table>";
mysqli_close($db);
?>
<script>
    function shownumbers_mi_sa(num_id){
        document.getElementById(num_id + '_mi_sa_date').style.background='#DB5353';
        var table = document.getElementById("mi_sa_table");
        for (let r of table.rows) {
            if(Number(r.id) === Number(num_id)){
                for (let cell of r.cells) {
                    console.log(cell.style.background);
                    if (cell.style.backgroundColor === "rgb(25, 121, 169)") {
                        document.getElementById("mi_sa" + cell.innerHTML).style.backgroundColor = "#DB5353";
                        document.getElementById("mi_sa" + cell.innerHTML).style.color = "white";
                    }
                }
            }

        }
    }

    function mouseoutfunc_mi_sa(num_id){
        document.getElementById(num_id + '_mi_sa_date').style.background='white';
        for(let c=1; c<=42; c++){
            document.getElementById("mi_sa" + c).style.backgroundColor = "white";
            document.getElementById("mi_sa" + c).style.color = "black";
        }
    }
</script>
