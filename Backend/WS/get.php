<?php

include_once ('connect.php');

$date = date_create(); $date = date_format($date,'Y-m-d H:i:s');

$temp = $_GET['temp'] / 10;
$humidity = $_GET['humidity'] / 10;
$trame = $_GET['trame'];
$result = true;
$txtnotification = 'ESSAIMAGE';
$periode = 0;


if ($trame == 1){
	if (isset($_GET['w1'])){

		$weight = $_GET['w1'] / 100;
		$rucheid = 1;

		check_essaimage($rucheid, $weight, $txtnotification, $periode);

		$addmonitor = "INSERT INTO $database.`monitoring` (`ID`, `RUCHEID`, `WEIGHT`, `TEMP`, `HUMIDITY`, `TIMESTAMP`) VALUES (NULL, '$rucheid', '$weight', '$temp', '$humidity', '$date');";
		$resaddmonitor = mysql_query($addmonitor)	 or die ("execution de la requete impossible");

		if ($resaddmonitor == 1) {
			$result = true;
		} else {
			$result = false;
		}
	}

	if (isset($_GET['w2'])){

		$weight = $_GET['w2'] / 100;
		$rucheid = 2;

		check_essaimage($rucheid, $weight, $txtnotification, $periode);

		$addmonitor = "INSERT INTO $database.`monitoring` (`ID`, `RUCHEID`, `WEIGHT`, `TEMP`, `HUMIDITY`, `TIMESTAMP`) VALUES (NULL, '$rucheid', '$weight', '$temp', '$humidity', '$date');";
		$resaddmonitor = mysql_query($addmonitor)	 or die ("execution de la requete impossible");

		if ($resaddmonitor == 1) {
			$result = true;
		} else {
			$result = false;
		}
	}

	if (isset($_GET['w3'])){

		$weight = $_GET['w3'] / 100;
		$rucheid = 3;

		check_essaimage($rucheid, $weight, $txtnotification, $periode);

		$addmonitor = "INSERT INTO $database.`monitoring` (`ID`, `RUCHEID`, `WEIGHT`, `TEMP`, `HUMIDITY`, `TIMESTAMP`) VALUES (NULL, '$rucheid', '$weight', '$temp', '$humidity', '$date');";
		$resaddmonitor = mysql_query($addmonitor)	 or die ("execution de la requete impossible");

		if ($resaddmonitor == 1) {
			$result = true;
		} else {
			$result = false;
		}
	}
} elseif ($trame == 2){

	if (isset($_GET['w1'])){

		$weight = $_GET['w1'] / 100;
		$rucheid = 4;

		check_essaimage($rucheid, $weight, $txtnotification, $periode);

		$addmonitor = "INSERT INTO $database.`monitoring` (`ID`, `RUCHEID`, `WEIGHT`, `TEMP`, `HUMIDITY`, `TIMESTAMP`) VALUES (NULL, '$rucheid', '$weight', '$temp', '$humidity', '$date');";
		$resaddmonitor = mysql_query($addmonitor)	 or die ("execution de la requete impossible");

		if ($resaddmonitor == 1) {
			$result = true;
		} else {
			$result = false;
		}
	}

	if (isset($_GET['w2'])){

		$weight = $_GET['w2'] / 100;
		$rucheid = 5;

		check_essaimage($rucheid, $weight, $txtnotification, $periode);

		$addmonitor = "INSERT INTO $database.`monitoring` (`ID`, `RUCHEID`, `WEIGHT`, `TEMP`, `HUMIDITY`, `TIMESTAMP`) VALUES (NULL, '$rucheid', '$weight', '$temp', '$humidity', '$date');";
		$resaddmonitor = mysql_query($addmonitor)	 or die ("execution de la requete impossible");

		if ($resaddmonitor == 1) {
			$result = true;
		} else {
			$result = false;
		}
	}

	if (isset($_GET['w3'])){

		$weight = $_GET['w3'] / 100;
		$rucheid = 6;

		check_essaimage($rucheid, $weight, $txtnotification, $periode);

		$addmonitor = "INSERT INTO $database.`monitoring` (`ID`, `RUCHEID`, `WEIGHT`, `TEMP`, `HUMIDITY`, `TIMESTAMP`) VALUES (NULL, '$rucheid', '$weight', '$temp', '$humidity', '$date');";
		$resaddmonitor = mysql_query($addmonitor)	 or die ("execution de la requete impossible");

		if ($resaddmonitor == 1) {
			$result = true;
		} else {
			$result = false;
		}


	}

}


/*

if (isset($_GET['vcc'])){

$attribut = 'VCC';
$float_val = $_GET['vcc'];
$char_val = '';

$addmonit_day = "INSERT INTO `follow`.`monit_day` (`ID`, `ATTRIBUT`, `FLOAT_VAL`, `CHAR_VAL`, `TIMESTAMP`) VALUES (NULL, '$attribut', '$float_val', '$char_val', '$date');";
$resaddmonit_day = mysql_query($addmonit_day)	 or die ("execution de la requete impossible");


if ($resaddmonit_day == 1) {
$result = true;
} else {
$result = false;
}

if ($float_val < 7 ){

$to = 'perso.agarde@gmail.com'; // Déclaration de l'adresse de destination.

$subject = '[Alerte Rucher] Batterie faible';

$msg = 'La batterie a atteint le seuil d\'alerte : '.$float_val.' V';

$headers = 'From: Rucher <perso.agarde@gmail.com>'."\r\n";
$headers .= "\r\n";

mail($to, $subject, $msg, $headers);
}

}
*/

if ($result = true ){
	echo 'OK_NAS';
}


function check_essaimage($rucheid, $actualweight, $txtnotification, $periode){
	$query = "SELECT `ID`, `weight` , `timestamp` FROM `monitoring` WHERE `RUCHEID` = $rucheid ORDER BY `ID` DESC LIMIT 1";
	$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());


	while ($row = mysql_fetch_array($result)) {

		$lastweight =   ($row["weight"]);
	};

	if (($lastweight - $actualweight) > 0.5){

		include 'notification/conf_notif.php';

		echo 'ruche = '.$rucheid.'<br>';
		echo 'text = '.$txtnotification.'<br>';
		echo 'periode = '.$periode.'<br>';

		$status = checkactif ($rucheid,$txtnotification,$periode);
		echo 'status = '.$status ;
		if ($status == 1) {


			updateNotifDate ($rucheid, $txtnotification);

			$to = 'mail@mail.com'; // Déclaration de l'adresse de destination.

			$subject = '[Alerte Rucher] Essaimage ruche : '.$rucheid.'';
			$msg = "Essaimage pour la ruche : $rucheid \n ";
			$msg .= "Ancien poids = $lastweight kg, Nouveau poids = $actualweight kg \n";

			$headers = 'From: Rucher <mail@mail.com>'."\r\n";
			$headers .= "\r\n";

			mail($to, $subject, $msg, $headers);

			$date = date_create(); $date = date_format($date,'Y-m-d H:i:s');
			$addnote = "INSERT INTO $database.`note` (`id`, `rucheid`, `notelong`, `rating`, `poids`, `datetime`) VALUES (NULL, '$rucheid', '$msg', '0', '0.0', '$date');";
			$resaddnote = mysql_query($addnote)	 or die ("execution de la requete impossible");
		} else {

		}
	}

}

?>

