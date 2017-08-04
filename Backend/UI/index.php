<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="FR">
	<head>

		<!-- Basic Page Needs-->
		<meta charset="utf-8">
		<title>Ruche <?php echo $rucheid; ?></title>
		<meta name="description" content="Suivi du rucher">
		<meta name="author" content="Miron Catalin Gabriel">

		<!-- Mobile Specific Metas-->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- FONT-->
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>

		<!-- CSS-->
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/skeleton.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="css/jquery.fancybox.css">
		<link rel="stylesheet" href="css/style.css">

		<!-- Favicon-->
		<link rel="icon" type="image/png" href="images/favicon.ico" />

		<!-- Javascript-->
		<script type="text/javascript" src="js/jquery.2.1.3.min.js"></script>
		<script type="text/javascript" src="js/isotope.pkgd.min.js"></script>
		<script type="text/javascript" src="js/scrollreveal.js"></script>
		<script type="text/javascript" src="js/singlenav.js"></script>
		<script type="text/javascript" src="js/jquery.fancybox.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="https://code.highcharts.com/stock/highstock.js"></script>
		<script type="text/javascript" src="https://code.highcharts.com/highcharts-more.js"></script>
		<script type="text/javascript" src="http://code.highcharts.com/modules/exporting.js"></script>
		<script type="text/javascript" src="https://code.highcharts.com/modules/solid-gauge.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>


	</head>
	<body>

		<!-- Menu -->
		<nav class="navigation">
			<a href="#" class="menu-icon">
				<i class="fa fa-bars"></i>
			</a>
			<ul class="main-navigation">
				<li><a href="#header">Ruche</a></li>
				<li><a href="#hero">Home</a></li>
				<li><a href="#suivi">Données</a></li>
				<li><a href="#graph">Graphique</a></li>
				<li><a href="#hausse">Hausse</a></li>
				<li><a href="#note">Notes</a></li>
			</ul>
		</nav>

		<section data-sr id="hero" class="hero u-full-width">
			<div class="<?php echo $color ?>"></div>
			<div class="container centered">
				<div class="twelve columns">
					<h1 class="separator">Ruche <?php echo $rucheid; ?></h1>
					<h2>Interface permettant le suivi des ruches</h2>
				</div>
			</div>
		</section>

		<section data-sr id="suivi" class="about u-full-width">
					<?php include 'fonctiongraph.php'; ?>
			<div class="container">
				<div class="row">
					<div class="twelve columns">
						<h3 class="separator">Suivi temps reel</h3>
						<h4>Accèder aux données de poids, températures, humidités en quasi temps réel. Etre informé de l'évolution du poids, de l'état de remplissage des hausses</h4>
					</div>
				</div>
				<div class="row">
					<ul class="services">
						<li class="three columns">
							<div class="service-image">
								<img src="images/services/weight.png">
							</div>
							<h5><?php echo $weight.' Kg'; ?></h5>
						</li>
						<li class="three columns">
							<div class="service-image">
								<img src="images/services/humidity.png">
							</div>
							<h5><?php echo $humidity.' %'; ?></h5>
						</li>
						<li class="three columns">
							<div class="service-image">
								<img src="images/services/temperature.png">
							</div>
							<h5><?php echo $temp.' °C'; ?></h5>
						</li>
						<li class="three columns">
							<div class="service-image">
								<img src="images/services/graph.png">
							</div>
							<h5><?php echo $diffsem.' Kg'; ?></h5>
						</li>
					</ul>
				</div>
			</div>
		</section>

		<section data-sr id="graph" class="graph u-full-width">
			<div id="contain_graph">
			</div>
		</section>


		<section data-sr id="hausse" class="about u-full-width">
			<div class="container">
				<div class="row">
					<div class="twelve columns">
						<h3 class="separator">Gestion des hausses</h3>
						<h4>Ajouter ou supprimer une hausse lors de la prise de notes</h4>
					</div>
				</div>
				<div class="row">
					<?php include 'hausse.php'; ?>
				</div>
				<div class="row">
					<ul class="people-list">
						<?php
						while ($i < $nbhausse){
							$i ++;
							echo '<li class="three columns people-list-item blank-feature">
							<div class="vert-centered">
							Hausse '.$i.'
							<progress max="100" value="'.round($tab_percenrempl[$i],2).'"></progress>
							</div>
							</li>';

						}
						?>
					</ul>
				</div>
			</div>
		</section>

		<section data-sr id="note" class="about u-full-width">
			<div class="container">
				<div class="row">
					<div class="twelve columns">
						<h3 class="separator">Prise de notes</h3>
						<h4>Suivi du rucher par prise de notes lors des visites</h4>
					</div>
				</div>
				<div class="row">
					<FORM method=GET action="index.php?rucheid=<?php echo $rucheid ?>#note">
						<textarea class="u-full-width" placeholder="suivi..." name="textnote" id="exampleMessage"></textarea>
						<input type="hidden" name="rucheid" value=<?php echo $rucheid ?>>
						<input class="button-primary" type="submit" value="Envoyer">
					</form>
				</div>
				<div class="row">
					<div class="docs-section" id="historique">
						<h5 class="docs-header">HISTORIQUE</h5>


						<table class="u-full-width">
							<thead>
								<tr>
									<th>date</th>
									<th>Note</th>
									<th>Poids</th>
									<th>Action</th>
								</tr>
							</thead>
							<!--<tbody>-->
							<?php

							$query = "SELECT `notelong` , `rating` , `datetime` , `poids` , `id` FROM `note` WHERE `rucheid`= $rucheid ORDER by `datetime` DESC";
							$res = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

							$total = mysql_num_rows($res);


							if($total){
								while($row = mysql_fetch_array($res)) {
									$currentrow = $row["id"];
									echo '<tbody id='.$row["id"].'
									<tr>
									<td>'.htmlentities($row["datetime"]).'</td>';
		
									if ($editnote==1 and $rowid==$row["id"]){
										echo '<td>';

										// recuperation du commentaire précédent
										$querynote = "SELECT `notelong` FROM `note` WHERE `id`= $rowid";
										$resnote = mysql_query($querynote) or die ("Erreur SQL !".$querynote."<br />".mysql_error());
										while($rownote = mysql_fetch_array($resnote)) {

											$lastnote = $row["notelong"];

										}
										echo'
										<FORM method=GET action="index.php?rucheid='.$rucheid.'#'.$currentrow.'">
										<textarea class="u-full-width" name="edit_comment">'.$lastnote.'</TEXTAREA>
										<input type="hidden" name="rowid" value='.$row["id"].'>
										<input class="button-primary" type="submit" value="Envoyer">
										</form>
										</td><td></td><td>
										
										<form action="index.php?rucheid='.$rucheid.'#'.$currentrow.'" method="GET">
										<input type="hidden" name="del_comment" value="1">
										<input type="hidden" name="rowid" value='.$row["id"].'>
										<input type="submit" value="supprimer">
										</form>
										</td>';
										
									}else{
										echo '<td>'.($row["notelong"]).'<br><br>';
										
										// recuperation des photos
										$queryphoto = "SELECT `path` FROM `photonote` WHERE `ID` = $currentrow";
										$resphoto = mysql_query($queryphoto) or die ("Erreur SQL !".$queryphoto."<br />".mysql_error());
										while($rowphoto = mysql_fetch_array($resphoto)) {

											$thumb_src = 'uploads/thumbs/'.$rowphoto["path"];
											
											echo '<img src="'.$thumb_src.'" alt="">';

										}
										
										
										echo '
										</td>
										<td>'.($row["poids"]).'</td>';
										
									}
									if ($editnote==1){} else {
										echo '
										<td>
										<form action="index.php?rucheid='.$rucheid.'#'.$currentrow.'" method="GET">
										<input type="hidden" name="editnote" value="1">
										<input type="hidden" name="rucheid" value='.$rucheid.'>
										<input type="hidden" name="rowid" value='.$currentrow.'>
										<input type="submit" value="modifier">
										</form>
										<form action="index.php?rucheid='.$rucheid.'#'.$currentrow.'" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="prowid" value='.$currentrow.'>
											<input type="file" name="image"/>
											<input type="submit" name="submit" value="Upload"/>
										</form>
										</td>
									';}
									echo '</tr></tbody>';


								}
							}


							?>

							<!--</tbody>-->
						</table>
					</div>
				</div>
			</div>
		</section>

		<section data-sr id="notification" class="about u-full-width">
			<div class="container">
				<div class="row">
					<div class="twelve columns">
						<h3 class="separator">Gestion Notifications</h3>
						<h4>Activer ou désactiver les notifications</h4>
					</div>
				</div>
				<div class="row">
					<ul class="services">
						<li class="three columns">
						<h5>Poids faible</h5>
						<?php echo '
							<form action="index.php?rucheid='.$rucheid.'#notification" method="GET">
								<input type="hidden" name="POIDSFAIBLE" value="'.$statuspoidsfaible.'">
								<input type="hidden" name="rucheid" value='.$rucheid.'>';
								if ( $statuspoidsfaible == 1 ) {
									echo '<input class="button-primary" type="submit" value="Désactiver">';
								} else{
									echo '<input class="button-primary" type="submit" value="Activer">';
								}
							?>					
							</form>
						</li>
						<li class="three columns">
						<h5>Essaimage</h5>
						<?php echo '
							<form action="index.php?rucheid='.$rucheid.'#notification" method="GET">
								<input type="hidden" name="ESSAIMAGE" value="'.$statusessaimage.'">
								<input type="hidden" name="rucheid" value='.$rucheid.'>';
								if ( $statusessaimage == 1 ) {
									echo '<input class="button-primary" type="submit" value="Désactiver">';
								} else{
									echo '<input class="button-primary" type="submit" value="Activer">';
								}
						?>					
							</form>
						</li>
						<li class="three columns">
						<h5>Miellée</h5>
						<?php echo '
							<form action="index.php?rucheid='.$rucheid.'#notification" method="GET">
								<input type="hidden" name="MIELLEE" value="'.$statusmiellee.'">
								<input type="hidden" name="rucheid" value="'.$rucheid.'">';
								
								if ( $statusmiellee == 1 ) {
									echo '<input class="button-primary" type="submit" value="Désactiver">';
								} else{
									echo '<input class="button-primary" type="submit" value="Activer">';
								}
						?>					
							</form>
						</li>
						<li class="three columns">
						<h5>Hausse Pleine</h5>
						<?php echo '
							<form action="index.php?rucheid='.$rucheid.'#notification" method="GET">
								<input type="hidden" name="HAUSSEPLEINE" value="'.$statushaussepleine.'">
								<input type="hidden" name="rucheid" value="'.$rucheid.'">';
								
								if ( $statushaussepleine == 1 ) {
									echo '<input class="button-primary" type="submit" value="Désactiver">';
								} else{
									echo '<input class="button-primary" type="submit" value="Activer">';
								}
						?>					
							</form>
						</li>
					</ul>
				</div>
			</div>
		</section>
		
		<!-- Footer -->

		<section data-sr class="footer u-full-width">
			<div class="container">
				<div class="row">
					<div class="twelve columns">
						<h5>&copy 2017 Aurélien GARDE</h5>
						<h6><?php echo 'Date dernier enregistrement = '.$datetime.'';?></h6>
					</div>
				</div>
			</div>
		</section>

		<!-- End Document-->
	</body>
</html>