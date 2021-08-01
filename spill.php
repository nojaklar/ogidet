<!DOCTYPE html>

<HTML>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
	<title>Og i det</title>
	<link rel="stylesheet" type="text/css" href="css/ogidet.css">

	<style>
	
body {
        background-color: #EDD1B0;
    }

div.main {
  position:absolute;
  top:30%;
  left:50%;
  padding:15px;
  -ms-transform: translateX(-50%) translateY(-50%);
  -webkit-transform: translate(-50%,-50%);
  transform: translate(-50%,-50%);
}
	

	
div.menuright {
  position:absolute;
  top:10%;
  left:93%;
  padding:15px;
  -ms-transform: translateX(-50%) translateY(-50%);
  -webkit-transform: translate(-50%,-50%);
  transform: translate(-50%,-50%);
}

div.menuStartNext {
  position:absolute;
  top:67%;
  left:93%;
  padding:15px;
  -ms-transform: translateX(-50%) translateY(-50%);
  -webkit-transform: translate(-50%,-50%);
  transform: translate(-50%,-50%);
}

DIV.word {
	font-family: 'Helvetica', 'Arial', sans-serif;
	letter-spacing:1px;
	display: inline-block;
	padding: 5px;
	text-align: center;
	font-size: 40px;
	transition: all 0.2s ease-out;
}


.price {
  position:relative;
  /*top:50%;*/
  /*left:45%;*/
  text-align: center;
  font-size: 75px;
  /*width: 600px;*/
	
	
}

.price img {
    max-height:75px;
    max-width:75px;
	
 }

div.score {
  position:absolute;
  top:5%;
  left:2%;
	
	
}

div.score_bronze {
	color: #C9AE5D;
	font: small-caps bold 24px/1 sans-serif;
	
}

div.score_silver {
	color: #C0C0C0;
	font: small-caps bold 24px/1 sans-serif;
	
}


div.score_gold {
	color: #DAA520;
	font: small-caps bold 24px/1 sans-serif;
	
}


div.price_bronze {
	color: #C9AE5D;
	
}

div.price_silver {
	color: #C0C0C0;
	
}

div.price_gold {
	color: #DAA520;
	
}


input.next {
		font-size : 20px; 
		width: 7em;  
		height: 5em;
		background-color: #D6BF94;
}

	
	
	
	:root {
  --animationDurationSplitt: 4s;
  --animationDelaySplitt: 4s;
  
	}
	
	.ordSplitt1 {
  position: relative;
  animation-name: ordSplitt1;
  animation-duration: var(--animationDurationSplitt);
  animation-delay: var(--animationDelaySplitt);
  animation-fill-mode: forwards;
}

@keyframes ordSplitt1 {
  0%   {left:0px; top:0px;}
  100% {left:7px; top:0px;}
}

.ordSplitt2 {
  position: relative;
  animation-name: ordSplitt2;
  animation-duration: var(--animationDurationSplitt);
  animation-delay: var(--animationDelaySplitt);
  animation-fill-mode: forwards;
}

@keyframes ordSplitt2 {
  0%   {left:0px; top:0px;}
  100% {left:15px; top:0px;}
}


div.price_hide {
  -webkit-animation: seconds 1.0s forwards;
  -webkit-animation-iteration-count: 1;
  -webkit-animation-delay: 5s;
  animation: seconds 1.0s forwards;
  animation-iteration-count: 1;
  animation-delay: 1500ms;
  
  
}
@-webkit-keyframes seconds {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    left: -9999px; 
  }
}
@keyframes seconds {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    left: -9999px; 
  }
}


.blink_me {
  animation: blinker .5s linear;
  
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}


	
	</style>
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
$prev_bronze = $_POST['score_bronze'];
$prev_silver = $_POST['score_silver'];
$prev_gold = $_POST['score_gold'];



if (in_array($pid, $pid_list)) {

#----------------------




$buttonNext=""; $buttonEnd=""; $sqlCurrentWord="";  $resultCurrentWord = "";  $getCurrentWord = "";  $word = "";  $id = "";  $starttime = ""; $startmillisecond = "";


//getWord function
function getWord($conn,$pid,&$sqlCurrentWord,&$resultCurrentWord ,&$getCurrentWord ,&$word ,&$id,&$starttime,&$startmillisecond)
{
	//global $pid;
	
	//test wordsplitt sql 141 = 1 splitt 197 = 2 splitt
	//$sqlCurrentWord = "SELECT 3654625476514, ID, STRING_HTML AS WORD, now(3) AS STARTTIME, ROUND(UNIX_TIMESTAMP(CURTIME(4)) * 1000) AS STARTMILLISECOND FROM WORD WHERE ID = 197"; 

	
	//$sqlCurrentWord = "SELECT PID, WORDID, WORD, STARTTIME, STARTMILLISECOND FROM V_WORD_GAME WHERE PID = ".$pid." ORDER BY RAND() LIMIT 1";
		
	$sqlCurrentWord ="WITH PLAYER_WORD AS
(
	SELECT 
	T1.PID
	, T2.ID AS WORDID
	, T2.WORDRANK
	 FROM PLAYER T1
	JOIN WORD T2 ON 1=1
	WHERE T1.PID = ".$pid."
	ORDER BY T2.WORDRANK
)
, PREVIOUS_WORD_BASIS AS
(
    SELECT T1.WORDID, T1.PID, RANK() OVER (PARTITION BY T1.PID ORDER BY T1.ID DESC) AS WORD_RANK
	 from WORD_LOG T1
	 WHERE T1.PID = ".$pid."
)
, PREVIOUS_WORD AS
(
	SELECT WORDID, PID FROM PREVIOUS_WORD_BASIS WHERE WORD_RANK = 1
)

, SYLLABLE AS -- FINNER ORD HVOR STAVELSE IKKE ER GODKJENT SLIK AT DE KAN FJERNES
(
	SELECT DISTINCT T2.PID, T1.WORD_WORD_ID AS WORDID FROM WORD_SYLLABLE_MAP T1
	JOIN V_ORD T2 ON T1.SYLLABLE_WORD_ID = T2.WORDID
	WHERE T2.BRONZE_STARS < 5
	AND T2.SILVER_STARS < 5
	AND T2.GOLD_STARS < 5
	AND T2.PID = ".$pid."
)
, BRONZE AS
(
	SELECT T1.PID, T1.WORDID FROM PLAYER_WORD T1
	-- FJERNE DE SOM ER KLART PÅ DETTE NIVÅ
	LEFT JOIN V_BRONZE_STARS T2 ON T1.PID = T2.PID AND T1.WORDID = T2.WORDID AND T2.BRONZE_STARS >= 5
	-- FJERNE DE SOM ER KLART PÅ HØYERE NIVÅ
	LEFT JOIN V_SILVER_STARS T3 ON T1.PID = T3.PID AND T1.WORDID = T3.WORDID AND T3.SILVER_STARS >= 5
	LEFT JOIN V_GOLD_STARS T4 ON T1.PID = T4.PID AND T1.WORDID = T4.WORDID AND T4.GOLD_STARS >= 5
	WHERE 1=1
	AND T2.WORDID IS NULL
	AND T3.WORDID IS NULL
	AND T4.WORDID IS NULL
	AND T1.PID = ".$pid."
)
, SILVER AS
(
	SELECT T1.PID, T1.WORDID FROM PLAYER_WORD T1
	-- FJERNE DE SOM ER KLART PÅ DETTE NIVÅ
	LEFT JOIN V_SILVER_STARS T2 ON T1.PID = T2.PID AND T1.WORDID = T2.WORDID AND T2.SILVER_STARS >= 5
	-- FJERNE DE SOM ER KLART PÅ HØYERE NIVÅ
	LEFT JOIN V_GOLD_STARS T3 ON T1.PID = T3.PID AND T1.WORDID = T3.WORDID AND T3.GOLD_STARS >= 5
	WHERE 1=1
	AND T2.WORDID IS NULL
	AND T1.PID = ".$pid."
)
, GOLD AS
(
	SELECT T1.PID, T1.WORDID FROM PLAYER_WORD T1
	LEFT JOIN V_GOLD_STARS T2 ON T1.PID = T2.PID AND T1.WORDID = T2.WORDID AND T2.GOLD_STARS >= 5
	WHERE 1=1
	AND T2.WORDID IS NULL
	AND T1.PID = ".$pid."
)
, GROUP_BRONZE AS
(
	SELECT T1.PID, T1.WORDID
	FROM BRONZE T1
	LEFT JOIN PREVIOUS_WORD T2 ON T1.WORDID = T2.WORDID AND T1.PID = T2.PID
	LEFT JOIN SYLLABLE T3 ON T1.WORDID = T3.WORDID AND T1.PID = T3.PID
	WHERE 1=1
	AND T2.WORDID IS NULL
	AND T3.WORDID IS NULL
	ORDER BY T1.WORDID
	LIMIT 10
)
-- SELECT * FROM GROUP_BRONZE;
, GROUP_SILVER AS
(
	SELECT T1.PID, T1.WORDID
	FROM SILVER T1
	LEFT JOIN PREVIOUS_WORD T2 ON T1.WORDID = T2.WORDID AND T1.PID = T2.PID
	LEFT JOIN BRONZE T3 ON T1.WORDID = T3.WORDID AND T1.PID = T3.PID
	LEFT JOIN SYLLABLE T4 ON T1.WORDID = T4.WORDID AND T1.PID = T4.PID
	WHERE 1=1
	AND T2.WORDID IS NULL
	AND T3.WORDID IS NULL
	AND T4.WORDID IS NULL
	ORDER BY T1.WORDID
	LIMIT 8
)
-- SELECT * FROM GROUP_SILVER;
, GROUP_GOLD AS
(
	SELECT T1.PID, T1.WORDID
	FROM GOLD T1
	LEFT JOIN PREVIOUS_WORD T2 ON T1.WORDID = T2.WORDID AND T1.PID = T2.PID
	LEFT JOIN BRONZE T3 ON T1.WORDID = T3.WORDID AND T1.PID = T3.PID
	LEFT JOIN SILVER T4 ON T1.WORDID = T4.WORDID AND T1.PID = T4.PID
	LEFT JOIN SYLLABLE T5 ON T1.WORDID = T5.WORDID AND T1.PID = T5.PID
	WHERE 1=1
	AND T2.WORDID IS NULL
	AND T3.WORDID IS NULL
	AND T4.WORDID IS NULL
	AND T5.WORDID IS NULL
	ORDER BY T1.WORDID
	LIMIT 5
)
-- SELECT * FROM GROUP_GOLD;
, RESULT AS
(
	SELECT PID, WORDID FROM GROUP_BRONZE
	UNION 
	SELECT PID, WORDID FROM GROUP_SILVER
	UNION 
	SELECT PID, WORDID FROM GROUP_GOLD
)
SELECT 
T1.PID
, T1.WORDID
, T2.STRING_HTML as WORD
, now(3) AS STARTTIME
, ROUND(UNIX_TIMESTAMP(CURTIME(4)) * 1000) AS STARTMILLISECOND
 FROM RESULT T1
JOIN WORD T2 ON T1.WORDID = T2.ID
ORDER BY RAND() LIMIT 1";
		
		
	$resultCurrentWord = $conn->query($sqlCurrentWord);
	$getCurrentWord = $resultCurrentWord->fetch_assoc(); 
	$word = $getCurrentWord["WORD"];
	$id = $getCurrentWord["WORDID"];	
	$starttime = $getCurrentWord["STARTTIME"];
	$startmillisecond = $getCurrentWord["STARTMILLISECOND"];
}
	
	
function getPlayerName($conn,$pid)	
{
	$sqlCurrentPlayer = "SELECT NAME FROM PLAYER WHERE PID = ".$pid;
		
	$resultCurrentPlayer = $conn->query($sqlCurrentPlayer);
	$getCurrentWord = $resultCurrentPlayer->fetch_assoc(); 
	$name = $getCurrentWord["NAME"];
	return $name;
	
}


function logToDB($conn,$id,$pid,$stm,$stms)
{
	//$testMedalje ="ttetet";

	settype($id, "int");
		//logging time
		$sql = "insert into WORD_LOG (WORDID,PID, STARTTIME, STARTMILLISECOND, ENDTIME, ENDMILLISECOND) values ($id,$pid, '$stm','$stms', now(3), ROUND(UNIX_TIMESTAMP(CURTIME(4)) * 1000) )";
	 $returnLogId = checkingSql($conn, $sql);
	
	$Medalje = checkPrice($conn,$returnLogId);
	
	return $Medalje;
}

//checking function
function checkingSql($conn, $sql)
{	if (mysqli_query($conn, $sql)) { 
	    //echo "Record updated successfully";
		
		$last_id = $conn->insert_id;
		
	} else {
		echo "Error updating record: " . mysqli_error($conn);
	}
	
	return $last_id;
}

function checkPrice($conn,$returnLogId)
{
	$sql = "SELECT MEDAL_ID,MEDAL, LOWER(MEDAL_VALUE) AS MEDAL_VALUE FROM V_PRICE_LOG where ID = $returnLogId";
	
		
	$resultCurrentMedal = $conn->query($sql);
	$getCurrentMedal = $resultCurrentMedal->fetch_assoc(); 
	$MedalId = $getCurrentMedal["MEDAL_ID"];
	$Medal = $getCurrentMedal["MEDAL"];
	$MedalValue = $getCurrentMedal["MEDAL_VALUE"];
	
	if (isset($MedalId)) {
	$price = '<div class="price_'.$MedalValue.'"><img src = "img/stars/'.$MedalValue.'-test-star.png">'.$Medal.'</div>';
	}
	else {
		
	$price = "";
	}
	return $price;
}

function inGameScore($conn,$pid,$prev_bronze,$prev_silver,$prev_gold)
{
	
	$sql = "SELECT lower(MEDAL) as MEDAL, STARS FROM V_INGAME_SCORE_BOARD WHERE PID =  $pid ORDER BY RANK_ORDER";
	$i = 0;

	$score='<div class="stars">';
	
	if ($resultCurrentScore = $conn->query($sql)) {
		
		/* fetch associative array */
		while ($row = $resultCurrentScore->fetch_assoc()) {
			
			if($row["MEDAL"]=='bronze' and $row["STARS"] > $prev_bronze and isset($prev_bronze)){$score = $score .'<div class="blink_me">';}
			elseif($row["MEDAL"]=='silver' and $row["STARS"] > $prev_silver and isset($prev_silver)) {$score = $score .'<div class="blink_me">';}
			elseif($row["MEDAL"]=='gold' and $row["STARS"] > $prev_gold and isset($prev_gold)) {$score = $score .'<div class="blink_me">';}

			if($row["MEDAL"]=='bronze'){$score = $score .'<div class="score_bronze">';}
			elseif($row["MEDAL"]=='silver') {$score = $score .'<div class="score_silver">';}
			elseif($row["MEDAL"]=='gold') {$score = $score .'<div class="score_gold">';}
			
			 $score = $score .'<img src = "img/stars/'.$row["MEDAL"].'-test-star.png"> '.$row["STARS"].'<BR></div>';
			
			
			if($row["MEDAL"]=='bronze' and $row["STARS"] > $prev_bronze and isset($prev_bronze)){$score = $score .'</div>';}
			elseif($row["MEDAL"]=='silver' and $row["STARS"] > $prev_silver and isset($prev_silver)) {$score = $score .'</div>';}
			elseif($row["MEDAL"]=='gold' and $row["STARS"] > $prev_gold and isset($prev_gold)) {$score = $score .'</div>';}
			
			
			$previous[$i] = $row["STARS"];
			$i=$i+1;
			}
			
		}
		/* free result set */
		$resultCurrentScore->free();
		
		$score = $score.'</div>';
		
		$returnScore[0] = $score;
		$returnScore[1] = $previous[0];
		$returnScore[2] = $previous[1];
		$returnScore[3] = $previous[2];
		
		return $returnScore;
		 
	
	
}






	
if  ($_POST["process"] =="start") {
		
		// fetching star score
		$score = inGameScore($conn,$pid,$prev_bronze,$prev_silver,$prev_gold);
		
		//Getting word
		getWord($conn,$pid,$sqlCurrentWord,$resultCurrentWord,$getCurrentWord,$word ,$id,$starttime,$startmillisecond);
		

			// showing buttons
		//showButtons($buttonNext,$buttonEnd,$starttime,$startmillisecond,$id,$prev_bronz,$prev_silver,$prev_gold);
		
		$buttonNext = '<form action="spill.php?pid='.$pid.'" method="post">
						<input type="hidden" name="process" value="log+next" />
						<input type="hidden" name="starttime" value="'.$starttime.'" />
						<input type="hidden" name="startmillisecond" value="'.$startmillisecond.'" />
						<input type="hidden" name="id" value="'.$id.'" />
						<input type="submit" value="Neste" class="next"></form>';
					
		$buttonEnd = '<form action="spill.php?pid='.$pid.'" method="post">
					<input type="hidden" name="process" value="end" />
					<input type="hidden" name="id" value="'.$id.'" />
					<input type="submit" value="avslutt" class="next"></form>';
		
		
		}


		

elseif  ($_POST["process"] =="log+next") {


		$stm=$_POST["starttime"];
		$stms=$_POST["startmillisecond"];

		$id=$_POST["id"];			

		// logging to db and getting price if applicable
		$price = logToDB($conn,$id,$pid,$stm,$stms);
				
		// fetching star score		
		$score = inGameScore($conn,$pid,$prev_bronze,$prev_silver,$prev_gold);
		
				
		
		//Getting word
		getWord($conn,$pid,$sqlCurrentWord,$resultCurrentWord,$getCurrentWord,$word,$id,$starttime,$startmillisecond);

			// Showing buttons
		//showButtons($buttonNext,$buttonEnd,$starttime,$startmillisecond,$id,$prev_bronz,$prev_silver,$prev_gold);
		
		
		
			$buttonNext = '<form action="spill.php?pid='.$pid.'" method="post">
					<input type="hidden" name="process" value="log+next" />
					<input type="hidden" name="starttime" value="'.$starttime.'" />
					<input type="hidden" name="startmillisecond" value="'.$startmillisecond.'" />
					<input type="hidden" name="id" value="'.$id.'" />
					<input type="hidden" name="score_bronze" value="'.$score[3].'" />
					<input type="hidden" name="score_silver" value="'.$score[2].'" />
					<input type="hidden" name="score_gold" value="'.$score[1].'" />
					<input type="submit" value="Neste" class="next"></form>';
					
		$buttonEnd = '<form action="spill.php?pid='.$pid.'" method="post">
					<input type="hidden" name="process" value="end" />
					<input type="hidden" name="id" value="'.$id.'" />
					<input type="submit" value="avslutt" class="next"></form>';	
		
		
		}


elseif  ($_POST["process"] =="end") {

		$name = getPlayerName($conn,$pid);

		$word = "Bra jobba ".$name."!";
		// Show button
		//nextButton($buttonNext,$buttonEnd);	
		
		
		$buttonNext = '<form action="spill.php?pid='.$pid.'" method="post">
					<input type="hidden" name="process" value="start" />
					<input type="submit" value="Start" class="next"></form>';
	
		$buttonEnd='<form action="index.php?pid='.$pid.'" method="post">
					<input type="submit" value="End/Exit" class="next"></form>';
	
}

else // Ready for start 
	{
	$name = getPlayerName($conn,$pid);
		
	$word = "Klar til start ".$name."?";
	//nextButton($buttonNext,$buttonEnd);	
	
	
	$buttonNext = '<form action="spill.php?pid='.$pid.'" method="post">
					<input type="hidden" name="process" value="start" />
					<input type="submit" value="Start" class="next"></form>';
	
	$buttonEnd='<form action="index.php?pid='.$pid.'" method="post">
				<input type="submit" value="End/Exit" class="next"></form>';
	
	}
	
		// Listing word
		echo '<div class="price"><div class="price_hide">';
		echo $price;
		echo '</div></div>';

		echo '<div class="menuright">';
		echo $buttonEnd;
		echo '</div>';
		echo '<div class="menuStartNext">';
		echo $buttonNext;
		echo '</div>';
		echo '<div class="main"><div class="word">';
		echo $word;
		echo '</div></div>';
		echo '<div class="score">';
		echo $score[0];
		echo '</div>';
		


		
		
$conn->close();



#--------------------------


	
} else {

	echo "Hvis du har spørsmål, vennligst kontakt Lars";	

	
}


?>


</body>
</html>