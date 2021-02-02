<?php

include('db_connection.php');

if(isset($_POST['delete'])){
	$did = $_POST['id'];
	$sql = "DELETE FROM swisslottozahlentabelle WHERE id=$did";
	mysqli_query($db, $sql);
}

if(isset($_POST['submit_mi'])) {

	$Datum = $_POST['Datum_mi'];
	$Lottozahl1 = $_POST['Lottozahl1_mi'];
	$Lottozahl2 = $_POST['Lottozahl2_mi'];
	$Lottozahl3 = $_POST['Lottozahl3_mi'];
	$Lottozahl4 = $_POST['Lottozahl4_mi'];
	$Lottozahl5 = $_POST['Lottozahl5_mi'];
	$Lottozahl6 = $_POST['Lottozahl6_mi'];
	$Glueckszahl = $_POST['Glueckszahl_mi'];

	$Lottozahl_arr = array($Datum, $Lottozahl1, $Lottozahl2, $Lottozahl3, $Lottozahl4, $Lottozahl5, $Lottozahl6, $Glueckszahl);

	$db_control_mi = true;

	for($i=0; $i<sizeof($Lottozahl_arr); $i++){
		if($Lottozahl_arr[$i] === ""){
			$db_control_mi = false;
			echo "<script type='text/javascript'>alert('Es gab mindestens ein Feld ohne Wert');</script>";
			break;
		}
	}

	array_pop($Lottozahl_arr);
	array_shift($Lottozahl_arr);

	if(sizeof(array_unique($Lottozahl_arr))!== 6){
		$db_control_mi = false;
		echo "<script type='text/javascript'>alert('Es gab doppelte Werte oder mindestens 2 Felder ohne Wert');</script>";
	}

	$all_sql = "SELECT Datum FROM swisslottozahlentabelle WHERE Ziehung = 'Mittwoch'";

	$date_arr =  mysqli_fetch_array(mysqli_query($db,$all_sql), MYSQLI_NUM);

	for($d=0; $d<sizeof($date_arr); $d++){
		if($date_arr[$d] === $Datum){
			$db_control_mi = false;
			echo "<script type='text/javascript'>alert('Das Datum wurde schon Mal eingegeben');</script>";
		}
	}


	if($db_control_mi === true){
		$sql = "INSERT INTO swisslottozahlentabelle (Datum, Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Lottozahl6, Glueckszahl, Ziehung)
	VALUES ('$Datum','$Lottozahl1', '$Lottozahl2', '$Lottozahl3', '$Lottozahl4', '$Lottozahl5', '$Lottozahl6', '$Glueckszahl', 'Mittwoch')";
		mysqli_query($db, $sql);
	}
}


$sql_all = "SELECT * FROM swisslottozahlentabelle WHERE Ziehung = 'Mittwoch' ORDER BY Datum DESC ";
$result_mi = mysqli_query($db,$sql_all);

echo "<table id='mi_table'>";
while($row = mysqli_fetch_array($result_mi, MYSQLI_NUM)){
	$da = date("d.m.Y", strtotime($row[1]));
	echo "<tr id='$row[0]'>";
	echo "<form method='post'>";
	echo "<input type='hidden' name='id' value='$row[0]'>";
	echo "<td><input type='submit' name='delete' value='x' style='background: #DB5353; border-width: 0; color: white;'></td>";
	echo "</form>";
	echo "<td id='$row[0]_mi_date' style='width:80px; font-size:14px; font-family:Arial;background: white; color: #1a2c3f;}' onmouseover='shownumbers_mi($row[0]);' onmouseout='mouseoutfunc_mi($row[0]);'>". $da ."</td>";
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
    function shownumbers_mi(num_id){
        document.getElementById(num_id + '_mi_date').style.background='#DB5353';
        var table = document.getElementById("mi_table");
        for (let r of table.rows) {
            if(Number(r.id) === Number(num_id)){
                for (let cell of r.cells) {
                    console.log(cell.style.background);
                    if (cell.style.backgroundColor === "rgb(25, 121, 169)") {
                        document.getElementById("mi" + cell.innerHTML).style.backgroundColor = "#DB5353";
                        document.getElementById("mi" + cell.innerHTML).style.color = "white";
                    }
                }
            }

        }
    }

    function mouseoutfunc_mi(num_id){
        document.getElementById(num_id + '_mi_date').style.background='white';
        for(let c=1; c<=42; c++){
            document.getElementById("mi" + c).style.backgroundColor = "white";
            document.getElementById("mi" + c).style.color = "black";
        }
    }
</script>
