<?php

include('db_connection.php');

if(isset($_POST['delete'])){
	$did = $_POST['id'];
	$sql = "DELETE FROM euromillionszahlentabelle WHERE id=$did";
	mysqli_query($db, $sql);
}

if(isset($_POST['submit_fr'])){

	$Datum = $_POST['Datum_fr'];
	$Lottozahl1 = $_POST['Lottozahl1_fr'];
	$Lottozahl2 = $_POST['Lottozahl2_fr'];
	$Lottozahl3 = $_POST['Lottozahl3_fr'];
	$Lottozahl4 = $_POST['Lottozahl4_fr'];
	$Lottozahl5 = $_POST['Lottozahl5_fr'];
	$Glueckszahl1 = $_POST['Glueckszahl1_fr'];
	$Glueckszahl2 = $_POST['Glueckszahl2_fr'];

	$Lottozahl_arr = array($Datum, $Lottozahl1, $Lottozahl2, $Lottozahl3, $Lottozahl4, $Lottozahl5, $Glueckszahl1, $Glueckszahl2);

	$db_control_fr = true;

	for($i=0; $i<sizeof($Lottozahl_arr); $i++){
		if($Lottozahl_arr[$i] === ""){
			$db_control_fr = false;
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

	if(sizeof(array_unique($Lottozahl_arr))!== 5){
		$db_control_fr = false;
		echo "<script type='text/javascript'>alert('Es gab doppelte Werte oder mindestens 2 Felder ohne Wert');</script>";
	}

	$all_sql = "SELECT Datum FROM euromillionszahlentabelle WHERE Ziehung = 'Freitag'";

	$date_arr =  mysqli_fetch_array(mysqli_query($db,$all_sql), MYSQLI_NUM);

	for($d=0; $d<sizeof($date_arr); $d++){
		if($date_arr[$d] === $Datum){
			$db_control_fr = false;
			echo "<script type='text/javascript'>alert('Das Datum wurde schon Mal eingegeben');</script>";
		}
	}


	if($db_control_fr === true){
		$sql = "INSERT INTO euromillionszahlentabelle (Datum, Lottozahl1, Lottozahl2, Lottozahl3, Lottozahl4, Lottozahl5, Glueckszahl1, Glueckszahl2, Ziehung)
	VALUES ('$Datum','$Lottozahl1', '$Lottozahl2', '$Lottozahl3', '$Lottozahl4', '$Lottozahl5', '$Glueckszahl1', '$Glueckszahl2', 'Freitag')";
		mysqli_query($db, $sql);
	}
}


$sql_all = "SELECT * FROM euromillionszahlentabelle WHERE Ziehung = 'Freitag' ORDER BY Datum DESC ";
$result_fr = mysqli_query($db,$sql_all);

echo "<table id='fr_table'>";
while($row = mysqli_fetch_array($result_fr, MYSQLI_NUM)){
	$da = date("d.m.Y", strtotime($row[1]));
	echo "<tr id='$row[0]'>";
	echo "<form method='post'>";
	echo "<input type='hidden' name='id' value='$row[0]'>";
	echo "<td><input type='submit' name='delete' value='x' style='background: #DB5353; border-width: 0; color: white;'></td>";
	echo "</form>";
	echo "<td id='$row[0]_fr_date' style='width:80px; font-size:13px; font-family:Arial;background: white; color: #1a2c3f;}' onmouseover='shownumbers_fr($row[0]);' onmouseout='mouseoutfunc_fr($row[0]);'>". $da ."</td>";
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
    function shownumbers_fr(num_id){
        document.getElementById(num_id + '_fr_date').style.background='#DB5353';
        var table = document.getElementById("fr_table");
        for (let r of table.rows) {
            if(Number(r.id) === Number(num_id)){
                for (let cell of r.cells) {
                    console.log(cell.style.background);
                    if (cell.style.backgroundColor === "rgb(25, 121, 169)") {
                        document.getElementById("fr" + cell.innerHTML).style.backgroundColor = "#DB5353";
                        document.getElementById("fr" + cell.innerHTML).style.color = "white";
                    }
                }
            }
        }
    }

    function mouseoutfunc_fr(num_id){
        document.getElementById(num_id + '_fr_date').style.background='white';
        for(let c=1; c<=50; c++){
            document.getElementById("fr" + c).style.backgroundColor = "white";
            document.getElementById("fr" + c).style.color = "black";
        }
    }
</script>
