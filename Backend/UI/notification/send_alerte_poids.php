<?php
include '../connect.php';
include 'conf_notif.php';

$txtnotification = 'POIDSFAIBLE';
$periode = 7;
$rucheid = 1;

while ($rucheid <= $nbmaxruche) {
	echo '<br>';
	echo $rucheid;
	echo ' : ';

	$status = checkactif ($rucheid,$txtnotification,$periode);

	if ($status == 1) {
		$query = "SELECT `ID`, `weight` , `timestamp` FROM `monitoring` WHERE `RUCHEID` = $rucheid ORDER BY `ID` DESC LIMIT 1";
		$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

		while ($row = mysql_fetch_array($result)) {
			$lastweight =   ($row["weight"]);
		};

		echo $lastweight;

		if ( $lastweight < $poidsfaible ){


			updateNotifDate ($rucheid, $txtnotification);

			$to = 'mail@mail.com'; // Déclaration de l'adresse de destination.

			$subject = '[Alerte Rucher] Poids faible ruche : '.$rucheid.'';
			$msg = "Poids faible pour la ruche : $rucheid \n ";
			$msg .= "poids = $lastweight kg \n";

			$headers = 'From: Rucher <mail@mail.com>'."\r\n";
			$headers .= "\r\n";

			mail($to, $subject, $msg, $headers);
			echo 'mail envoyé';


		}
	} else {

		echo 'Pas de notif';
	}

	$rucheid++;
}

?>