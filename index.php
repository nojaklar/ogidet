<!DOCTYPE html>

<HTML>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Og i det</title>
	<link rel="stylesheet" type="text/css" href="css/ogidet.css">

</head>
<body class="pages">

<?php

#----------------------DB connection------------------------------------------
# kommando i docker cli for å koble til "mysql -h localhost -u devuser -p"
include 'db.php';
#----------------------DB connection------------------------------------------
#----------------------check list------------------------------------------
include 'check_list.php';
#----------------------check list------------------------------------------





$pid = $_GET['pid'];

if (in_array($pid, $pid_list)) {
	

echo '<h1>ogidet.no</h1>';

//hente navn på brukeren og legge inn navnet her
//hente inn scoren til brukeren og legge her

//dette er menyen
echo '<div class="grid">';
echo '<div class="grid-item"><a href="spill.php?pid=' . $pid . '" class="button">Spill</a></div>';
echo '<div class="grid-item"><a href="ord.php?pid=' . $pid . '" class="button">Ord</a></div>';
echo '<div class="grid-item"><a href="klistremerker.php?pid=' . $pid . '" class="button">Klistremerker</a></div>';
//echo '<div class="grid-item"><a href="index.php?pid=' . $pid . '" class="button">Hjem</a></div>'; // viser ikke denne siden dette er denne siden
echo '</div>';

	
} else {

	echo "Hvis du har spørsmål, vennligst kontakt Lars";	

	
}


?>


</body>
</html>