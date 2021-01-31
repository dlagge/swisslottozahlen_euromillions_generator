
<?php

$db = mysqli_connect( "localhost", "root", "root", "id14544610_swisslottozahlen" );
//$db=mysqli_connect("localhost","id14544610_lotto_admin", "Lottopasswort123!", "id14544610_swisslottozahlen");

if ( mysqli_connect_errno() ) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>