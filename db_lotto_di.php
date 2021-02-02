<?php

include('db_connection.php');

if(isset($_POST['delete'])){
	$did = $_POST['id'];
	$sql = "DELETE FROM euromillionszahlentabelle WHERE id=$did";
	mysqli_query($db, $sql);
}

if(isset($_POST['submit_di'])){

	$Datum = $_POST['Datum_di'];
	$Lottozahl1 = $_POST['Lottozahl1_di'];
	$Lottozahl2 = $_POST['Lottozahl2_di'];
	$Lottozahl3 = $_POST['Lottozahl3_di'];
	$Lottozahl4 = $_POST['Lottozahl4_di'];
	$Lottozahl5 = $_POST['Lottozahl5_di'];
	$Lottozahl6 = $_POST['Lottozahl6_di'];
	$Glueckszahl1 = $_POST['Glueckszahl1_di'];
	$Glueckszahl2 = $_POST['Glueckszahl2_di'];

	$Lottozahl_arr = array($Datum, $Lottozahl1, $Lottozahl2, $Lottozahl3, $Lottozahl4, $Lottozahl5, $Lottozahl6, $Glueckszahl1, $Glueckszahl2);

	$db_control_di = true;

	for($i=0; $i<sizeof($Lottozahl_arr); $i++){
		if($Lottozahl_arr[$i] === ""){
			$db_control_di = false;
			echo "<script type='text/javascript'>alert('Es gab mindestens ein Feld ohne Wert');</script>";
			break;
		}
	}

	if($Lottozahl_arr[sizeof($Lottozahl_arr)-1] === $Lottozahl_arr[sizeof($Lottozahl_arr)-2]) {
        echo "<script type='text/javascript'>alert('Die Glückszahlen dürfen nicht identisch sein');</script>";
	}

	array_pop($Lottozahl_arr);
	array_pop($Lottozahl_arr);
	array_shift($Lottozahl_arr);

	if(sizeof(array_unique($Lottozahl_arr))!== 6){
		$db_control_di = false;
		echo "<script type='text/javascript'>alert('Es gab doppelte Werte oder mindestens 2 Felder ohne Wert');</script>";
	}

	$all_sql = "SELECT Datum FROM euromillionszahlentabelle WHERE Ziehung = 'Dienstag'";

	$date_arr =  mysqli_fetch_array(mysqli_query($db,$all_sql), MYSQLI_NUM);

	for($d=0; $d<sizeof($date_arr); $d++){
		if($date_arr[$d] === $Datum){
			$db_control_di = false;
			echo "<script type='text/javascript'>alert('Das Datum wurde schon Mal eingegeben');</script>";
		}
	}


	if($db_control_di === true){
		$sql = "INSERT INTO euromillionszahlentabelle (Datum, Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Lottozahl6, Glueckszahl1, Glueckszahl2, Ziehung)
	VALUES ('$Datum','$Lottozahl1', '$Lottozahl2', '$Lottozahl3', '$Lottozahl4', '$Lottozahl5', '$Lottozahl6', '$Glueckszahl1', '$Glueckszahl2', 'Dienstag')";
		mysqli_query($db, $sql);
	}
}


$sql_all = "SELECT * FROM euromillionszahlentabelle WHERE Ziehung = 'Dienstag' ORDER BY Datum DESC ";
$result_di = mysqli_query($db,$sql_all);

echo "<table id='di_table'>";
while($row = mysqli_fetch_array($result_di, MYSQLI_NUM)){
	$da = date("d.m.Y", strtotime($row[1]));
	echo "<tr id='$row[0]'>";
	echo "<form method='post'>";
	echo "<input type='hidden' name='id' value='$row[0]'>";
	echo "<td><input type='submit' name='delete' value='x' style='background: #DB5353; border-width: 0; color: white;'></td>";
	echo "</form>";
	echo "<td id='$row[0]_di_date' style='width:80px; font-size:13px; font-family:Arial;background: white; color: #1a2c3f;}' onmouseover='shownumbers_di($row[0]);' onmouseout='mouseoutfunc_di($row[0]);'>". $da ."</td>";
	for($ll=1; $ll <= 50; $ll++){
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
		if($row[9] === strval($ll)){
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
    function shownumbers_di(num_id){
        document.getElementById(num_id + '_di_date').style.background='#DB5353';
        var table = document.getElementById("di_table");
        for (let r of table.rows) {
            if(Number(r.id) === Number(num_id)){
                for (let cell of r.cells) {
                    console.log(cell.style.background);
                    if (cell.style.backgroundColor === "rgb(25, 121, 169)") {
                        document.getElementById("di" + cell.innerHTML).style.backgroundColor = "#DB5353";
                        document.getElementById("di" + cell.innerHTML).style.color = "white";
                    }
                }
            }
        }
    }

    function mouseoutfunc_di(num_id){
        document.getElementById(num_id + '_di_date').style.background='white';
        for(let c=1; c<=50; c++){
            document.getElementById("di" + c).style.backgroundColor = "white";
            document.getElementById("di" + c).style.color = "black";
        }
    }
</script>
