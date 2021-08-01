<!DOCTYPE html>

<HTML>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
	<title>Og i det</title>
	<link rel="stylesheet" type="text/css" href="css/ogidet.css">

</head>
<body>

<?php

#----------------------DB connection------------------------------------------
include 'db.php';

#----------------------DB connection------------------------------------------
#----------------------check list------------------------------------------
include 'check_list.php';
#----------------------check list------------------------------------------


//ord.php?pid=3654625476514


$pid = $_GET['pid'];

if (isset($_GET['klistremerke'])) {
	
	if ($_GET['klistremerke'] == 'alle') {
		$klistremerke_filter = 'AND 1=1';
		$klistremerke=$_GET['klistremerke'];
	}
	else {
		$klistremerke_filter = ' AND concat(lower(CATEGORYNAME_CONCAT),",") like "%'.$_GET['klistremerke'].',%"';
		$klistremerke=$_GET['klistremerke'];
	}
} else {    
     $klistremerke_filter = ' AND 1=1';
}


if (in_array($pid, $pid_list)) {



$sqlResult = "SELECT PID, WORDID, WORD, BRONZE_STARS, SILVER_STARS, GOLD_STARS, CATEGORYNAME_CONCAT FROM V_ORD WHERE PID = $pid.$klistremerke_filter";
$sqlResultCategories = "SELECT CATEGORYNAME, LOWER(CATEGORYNAME) AS LOWER_CATEGORYNAME FROM CATEGORY";



	
	//echo "pid = " . $pid;	
//echo "Velkommen til ogidet.no";
//dette er menyen
echo '<div class="grid">';
echo '<div class="grid-item"><a href="spill.php?pid=' . $pid . '" class="button">Spill</a></div>';
//echo '<div class="grid-item"><a href="ord.php?pid=' . $pid . '" class="button">Ord</a></div>';
echo '<div class="grid-item"><a href="klistremerker.php?pid=' . $pid . '" class="button">Klistremerker</a></div>';// viser ikke denne siden dette er denne siden
echo '<div class="grid-item"><a href="index.php?pid=' . $pid . '" class="button">Hjem</a></div>'; 



//meny dropdown start
echo '<div class="grid-item">';    
echo '<form action="/ord.php?pid=">';
echo '<input name="pid" type="hidden" value="' . $pid . '"></input>';
  echo '<label for="klistremerke">Klistremerke:</label>';
  echo '<select name="klistremerke" id="klistremerke">';

	echo '<option value="alle">Alle</option>';
	$i=1;
		if ($resultResultCategories = $conn->query($sqlResultCategories)) {

		/* fetch associative array */
		while ($row = $resultResultCategories->fetch_assoc()) {


    echo '<option value="'.$row["LOWER_CATEGORYNAME"].'"';
		if ($klistremerke == $row["LOWER_CATEGORYNAME"])
			{
				ECHO ' SELECTED';
				}
			ELSE {}
		ECHO '>'.$row["CATEGORYNAME"].'</option>';
	
		}	
		/* free result set */
		$resultResultCategories->free();
	}
	
  echo '</select>';
  echo '<br><br>';
  
  echo '<input type="submit" value="Filtrer">';
echo '</form>';
echo '</div>'; 
// meny dropdown slutt


echo '</div>';
echo '<br>';
echo '<br>';
echo '<br>';
// meny slutt



ECHO '<div class="grid">';
	$i=1;
		if ($resultResult = $conn->query($sqlResult)) {

		/* fetch associative array */
		while ($row = $resultResult->fetch_assoc()) {
			
			ECHO'<div class="grid-item">';
				ECHO '<div class="ordet-i-grid">';
					ECHO '<h2>'.$row["WORD"].'</h2>';
				ECHO '</div>';
					ECHO '<div class="stars">';
						ECHO '<div class="stars-group">'; // bronze
						
							$x = 0;

							while($x <= 4) {
							  
								ECHO '<span class="grid-item-';
								IF ($row["BRONZE_STARS"] > $x ) {echo 'non-';}
								ECHO'filter"><img src = "img/stars/bronze-test-star.png"></span>';
							  
							$x++;
							}
						
					
						ECHO '</div>';
						
						ECHO '<div class="stars-group">'; // silver
						
							$x = 0;

							while($x <= 4) {
							  
								ECHO '<span class="grid-item-';
								IF ($row["SILVER_STARS"] > $x ) {echo 'non-';}
								ECHO'filter"><img src = "img/stars/silver-test-star.png"></span>';
							  
							$x++;
							}
						
						ECHO '</div>';						

						ECHO '<div class="stars-group">'; // gold
						
							$x = 0;

							while($x <= 4) {
							  
								ECHO '<span class="grid-item-';
								IF ($row["GOLD_STARS"] > $x ) {echo 'non-';}
								ECHO'filter"><img src = "img/stars/gold-test-star.png"></span>';
								  
							$x++;
							}
						
						ECHO '</div>';						
						
						
						
					ECHO '</div>';
					


				$categories_array=$row["CATEGORYNAME_CONCAT"];
				$categories_array = explode(',', $categories_array);
				$count=count($categories_array);
				
				ECHO '<div class="sma-klistremerker">';
				//ECHO '<img src = img/subjunksjon.png ><img src = img/adjektiv.png ><img src = img/adjektiv.png >';
				
				for ($x = 0; $x <= $count-1; $x++) {
				echo "<a href=/ord.php?pid=3654625476514&klistremerke=$categories_array[$x]><img src = img/$categories_array[$x].png ></a>";
				}

				ECHO '</div>';
				
			ECHO '</div>';
		}
		/* free result set */
		$resultResult->free();
	}

ECHO '</div>';
?>


<!-- TEMPLATE
<div class="grid">



	<div class="grid-item">
			<div class="ordet-i-grid"><h2>ordet</h2></div> 
			<div class="stars">
				<div class="stars-bronze">	
					<span class="grid-item-non-filter"><img src = "img/stars/bronze-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/bronze-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/bronze-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/bronze-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/bronze-star.png"></span>
				</div>
			
				<div class="stars-bronze">	
					<span class="grid-item-non-filter"><img src = "img/stars/silver-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/silver-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/silver-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/silver-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/silver-star.png"></span>
				</div>

				<div class="stars-bronze">	
					<span class="grid-item-non-filter"><img src = "img/stars/gold-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/gold-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/gold-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/gold-star.png"></span>
					<span class="grid-item-filter"><img src = "img/stars/gold-star.png"></span>
				</div>

			</div>
			<div class="sma-klistremerker">
				<img src = img/subjunksjon.png ><img src = img/adjektiv.png ><img src = img/adjektiv.png >
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