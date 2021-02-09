<?php

include('db_connection.php');

$sql_all = "SELECT * FROM euromillionszahlentabelle ORDER BY Datum DESC ";
$result_di_fr = mysqli_query($db,$sql_all);

echo "<table id='di_fr_table'>";
while($row = mysqli_fetch_array($result_di_fr, MYSQLI_NUM)){
	$da = date("d.m.Y", strtotime($row[1]));
	echo "<tr id='$row[0]'>";
	echo "<form method='post'>";
	echo "</form>";
	if($row[9] == "Dienstag"){
    	    echo "<td style='width:80px; font-size:14px; font-family:Arial;background: white; color: #1a2c3f;}'>Di</td>";
    } else {
    	    echo "<td style='width:80px; font-size:14px; font-family:Arial;background: white; color: #1a2c3f;}'>Fr</td>";
    }
	echo "<td id='$row[0]_di_fr_date' style='width:80px; font-size:13px; font-family:Arial;background: white; color: #1a2c3f;}' onmouseover='shownumbers_di_fr($row[0]);' onmouseout='mouseoutfunc_di_fr($row[0]);'>". $da ."</td>";
	for($ll=1; $ll <= 50; $ll++){
		$background = "white";
		$color = "#1a2c3f";
		$fontWeight = "";
		for($lll=2; $lll<7; $lll++){
			if($row[$lll] === strval($ll)){
				$background = "#1979a9";
			}
		}
		if($row[7] === strval($ll)){
			$color = "#DB5353";
			$fontWeight = "bold";
		}
		if($row[8] === strval($ll)){
        		$color = "#DB5353";
        		$fontWeight = "bold";
        }
		echo "<td style='width:20px; font-size:13px; font-family:Arial;background: $background; color: $color;font-weight:$fontWeight;'>". $ll ."</td>";
	}
	echo "</tr>";
}

echo "</table>";

mysqli_close($db);
?>
<script>
    function shownumbers_di_fr(num_id){
        document.getElementById(num_id + '_di_fr_date').style.background='#DB5353';
        var table = document.getElementById("di_fr_table");
        for (let r of table.rows) {
            if(Number(r.id) === Number(num_id)){
                for (let cell of r.cells) {
                    console.log(cell.style.background);
                    if (cell.style.backgroundColor === "rgb(25, 121, 169)") {
                        document.getElementById("di_fr" + cell.innerHTML).style.backgroundColor = "#DB5353";
                        document.getElementById("di_fr" + cell.innerHTML).style.color = "white";
                    }
                }
            }
        }
    }

    function mouseoutfunc_di_fr(num_id){
        document.getElementById(num_id + '_di_fr_date').style.background='white';
        for(let c=1; c<=50; c++){
            document.getElementById("di_fr" + c).style.backgroundColor = "white";
            document.getElementById("di_fr" + c).style.color = "black";
        }
    }
</script>
