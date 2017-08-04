<?php

$query = "SELECT `HAUSSEID` , `DATETIME` , `POIDSINITIAL` FROM `hausse` WHERE `RUCHEID`= $rucheid and `DEL` = 0 ORDER by `HAUSSEID` ASC";
$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

$total = mysql_num_rows($res);

echo '	<table class="u-full-width">
	  <thead>
		<tr>
		  <th>Hausse</th>
		  <th>Date de pose</th>
		  <th>Poids initial</th>
		  <th>Poids actuel</th>
		  <th>Action</th>
		</tr>
	  </thead>
	  <tbody>';

$nbhausse = 0;
$poidmaxhausse = 20;
	  
if($total){
	while($row = mysql_fetch_array($res)) {
		$percenrempl = 0;
		$nbhausse = $nbhausse + 1;
		
		/*calcul remplissage hausse*/
		unset($tab_rempl[$nbhausse]);
		$tab_rempl[$nbhausse] = $lastweight - $row["POIDSINITIAL"];
		$tab_percenrempl[$nbhausse] = $tab_rempl[$nbhausse] * (100 / $poidmaxhausse);
		if ($tab_percenrempl[$nbhausse] > 100){$tab_percenrempl[$nbhausse] = 100;}
		if ($tab_percenrempl[$nbhausse] < 0){$tab_percenrempl[$nbhausse] = 0;}
		//echo '<br>rempl'.$nbhausse.' :'.$tab_rempl[$nbhausse].' - Pourcentage'.round($tab_percenrempl[$nbhausse],2);
		
		/*affichage tableau remplissage hausse*/
		echo'<tr>
		<td>'.($row["HAUSSEID"]).'</td>
		<td>'.htmlentities($row["DATETIME"]).'</td>
		<td>'.($row["POIDSINITIAL"]).'</td>
		<td>'.$lastweight.'</td>
		<td>
		<form action="index.php#hausse" method="GET">
		<input type="hidden" name="delhausseid" value='.($row["HAUSSEID"]).'>
		<input type="hidden" name="rucheid" value='.$rucheid.'>
		<input type="submit" value="supprimer">
		</form></td>
		</tr>';
		$lasthausseid = ($row["HAUSSEID"]);
		

	}
}

$lasthausseid = $lasthausseid + 1;


echo'
 
</tbody>
</table>

<form action="index.php#hausse" method="GET">
<input type="hidden" name="addhausseid" value='.$lasthausseid.'>
<input type="hidden" name="rucheid" value='.$rucheid.'>
<input class="button-primary" type="submit" value="+ 1">
</form>';

?>
