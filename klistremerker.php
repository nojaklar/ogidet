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
include 'db.php';
#----------------------DB connection------------------------------------------

#----------------------check list------------------------------------------
include 'check_list.php';
#----------------------check list------------------------------------------



$pid = $_GET['pid'];

	
if (in_array($pid, $pid_list)) {
	
$sqlResult = 'SELECT CATEGORYNAME, LOWER_CATEGORYNAME, PERCENT_BRONZE, PERCENT_SILVER, PERCENT_GOLD FROM  V_KLISTREMERKE WHERE PID ='.$pid;
	
	//echo "pid = " . $pid;	
//echo "Velkommen til ogidet.no";

//dette er menyen
echo '<div class="grid">';
echo '<div class="grid-item"><a href="spill.php?pid=' . $pid . '" class="button">Spill</a></div>';
echo '<div class="grid-item"><a href="ord.php?pid=' . $pid . '" class="button">Ord</a></div>';
//echo '<div class="grid-item"><a href="klistremerker.php?pid=' . $pid . '" class="button">Klistremerker</a></div>';// viser ikke denne siden dette er denne siden
echo '<div class="grid-item"><a href="index.php?pid=' . $pid . '" class="button">Hjem</a></div>'; 
echo '</div>';
echo '<br>';



echo '<div class="grid">';

	$i=1;
		if ($resultResult = $conn->query($sqlResult)) {

		/* fetch associative array */
		while ($row = $resultResult->fetch_assoc()) {


	  echo '<div class="grid-item">';
		echo '<div class="grid-item-non-filter">';
	  
			echo '<a href="ord.php?pid=' . $pid . '&klistremerke='.$row["LOWER_CATEGORYNAME"].'"><img src = img/'.$row["LOWER_CATEGORYNAME"].'.png ></A>';
		echo '</div>';
		echo '<div class="klistremerkenavn">'.$row["CATEGORYNAME"].'</div>';
			echo '<div class="grid-sub-item">';
				echo '<div class="progress-bar">';
					echo '<span class="progress-bar-fill-bronze" style="width: '.$row["PERCENT_BRONZE"].'%;"></span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="grid-sub-item">';
				echo '<div class="progress-bar">';
					echo '<span class="progress-bar-fill-silver" style="width: '.$row["PERCENT_SILVER"].'%;"></span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="grid-sub-item">';
				echo '<div class="progress-bar">';
					echo '<span class="progress-bar-fill-gold" style="width: '.$row["PERCENT_GOLD"].'%;"></span>';
				echo '</div>';
			echo '</div>';
	  echo '</div>';
	  
	  
	  }
		/* free result set */
		$resultResult->free();
	}


echo '</div>';



?>


<!-- TEMPLATE-----
<div class="grid">
  <div class="grid-item">
	<div class="grid-item-non-filter">
  
		<img src = img/adjektiv.png >
	</div>
	<br>Adjektiv
		<div class="grid-sub-item">
			<div class="progress-bar">
				<span class="progress-bar-fill-bronze" style="width: 90%;"></span>
			</div>
		</div>
		<div class="grid-sub-item">
			<div class="progress-bar">
				<span class="progress-bar-fill-silver" style="width: 40%;"></span>
			</div>
		</div>
		<div class="grid-sub-item">
			<div class="progress-bar">
				<span class="progress-bar-fill-gold" style="width: 5%;"></span>
			</div>
		</div>
  </div>
</div>

-->


<?php





	
} else {

	echo "Hvis du har spørsmål, vennligst kontakt Lars";	

	
}


?>


</body>
</html>