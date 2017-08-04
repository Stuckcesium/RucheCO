<?php

$query = "SELECT `weight` , `timestamp` , `temp` , `humidity` FROM `monitoring` WHERE `RUCHEID` = $rucheid";
$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

while ($row = mysql_fetch_array($result)) {

	$weight =   ($row["weight"]);
	$temp = 	  ($row["temp"]);
	$humidity = ($row["humidity"]);

	//traitement sur la date
	$datetime = ($row["timestamp"]);
	//echo "datetime : "; echo $datetime;    echo"<br>";
	$prevmonth = date("n",strtotime($datetime))-1;// parce qu'en javascript 0 = janvier
	//echo "prevmonth : "; echo $prevmonth;    echo"<br>";
	$datetime1 = date('Y, '.$prevmonth.', j, H, i, s', strtotime($datetime)); //converts date from 2012-01-10 (mysql date format) to the format Highcharts understands 2012, 1, 10
	//echo "datetime1 : "; echo $datetime1;    echo"<br>";
	$datetime2 = 'Date.UTC('.$datetime1.')'; //getting the date into the required format for pushing the Data into the Series
	//echo "datetime2 : "; echo $datetime2;    echo"<br>";

	//echo "------------------------------------";echo"<br>";

	$data_weight[] = "[$datetime2, $weight]";
	//echo $data_weight[$i];     echo "<br>";
	$data_temp[] = "[$datetime2, $temp]";
	//echo $data_temp[$i];     echo "<br>";
	$data_humidity[] = "[$datetime2, $humidity]";

	//$i = $i+1;

}

/*******************last weight *********************************/
$query = "SELECT `ID`, `weight` , `timestamp` FROM `monitoring` WHERE `RUCHEID` = $rucheid ORDER BY `ID` DESC LIMIT 1";
$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

while ($row = mysql_fetch_array($result)) {
	$lastweight =   ($row["weight"]);
};

$diffsem = 0;

//difference de poids sur 7 jours.
//72 mesures par jour
//soit les 504 derniers enreg...
$nbenreg = 504; $echo = false;
$diffsem = round(diff_weight($rucheid, $nbenreg, $echo, $lastweight),2);

$nbenreg = 12; $echo = true;
$diff6hours = round(diff_weight($rucheid, $nbenreg, $echo, $lastweight),2);
// echo $diff6hours;echo "<br>";

$nbenreg = 72;
$moyenne24h = round(moyenne($rucheid, $nbenreg),2);
//echo $moyenne24h;echo "<br>";


$nbenreg = 2; $echo = false;
$diff2enreg = diff_weight($rucheid, $nbenreg, $echo, $lastweight);

$actual_vcc = get_vcc();


function diff_weight($rucheid, $nbenreg, $echo, $lastweight){

	$query = "SELECT `ID`, `weight` , `timestamp` 
				FROM `monitoring` 
				WHERE `RUCHEID` = $rucheid 
				ORDER BY `ID` 
				DESC LIMIT $nbenreg";
				
	$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	$i = 1 ;
	$diff = 0;
	while ($row = mysql_fetch_array($result)) {
		/*
		if ($echo == true ){
		echo ($row["weight"]);
		echo ' - ';
		}*/

		if ( $i == $nbenreg ) {
		
			 $id =   ($row["ID"]);
			 $weight =   ($row["weight"]);
			 $datetime = ($row["timestamp"]);
			 //echo $nbenreg.'<br>';
			 //echo $i;echo "-";
			 //echo $id;echo "/";
			 //echo $weight;echo "/";
			 //echo $lastweight;echo "/";
			 //echo $datetime;echo "<br>";
			
			$diff = $lastweight - $weight;
			return $diff;
		}

		$i = $i+1;

	};

	if (empty($diff)){
		$diff = 0;
		return $diff;

	}

}


function moyenne($rucheid, $nbenreg){

	$query = "SELECT `ID`, `weight` , `timestamp` FROM `monitoring` WHERE `RUCHEID` = $rucheid ORDER BY `ID` DESC LIMIT $nbenreg";
	$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());
	$i = 1 ;

	while ($row = mysql_fetch_array($result)) {

		$weight =  $weight + ($row["weight"]);

	};

	$moyenne = $weight / $nbenreg;
	return $moyenne;

}


function get_vcc(){

	$query = "SELECT `float_val` FROM `monit_day` WHERE `ATTRIBUT` = 'VCC' ORDER BY `ID` DESC LIMIT 1";
	$result = mysql_query($query) or die ('Erreur SQL !'.$query.'<br />'.mysql_error());

	while ($row = mysql_fetch_array($result)) {

		$vcc =   ($row["float_val"]);

		if (empty($vcc)){
			$vcc = 0;
		}

		return $vcc;

	}
}


?>

<script type="text/javascript">

	$(function() {

		$.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function(data) {
			// Create the chart
			window.chart = new Highcharts.StockChart({
				chart: {
					renderTo: 'contain_graph'
				},

				yAxis: [{ // Primary yAxis
					labels: {
						format: '{value}°C',
						style: {
							color: Highcharts.getOptions().colors[2]
						}
					},
					title: {
						text: 'Temperature',
						style: {
							color: Highcharts.getOptions().colors[2]
						}
					},
					opposite: true

				}, { // Secondary yAxis
					gridLineWidth: 0,
					title: {
						text: 'Poids',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					labels: {
						format: '{value} kg',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					}
				}],


				rangeSelector: {
					allButtonsEnabled: false,
					buttons: [{
						type: 'day',
						count: 1,
						text: 'Jour',
						dataGrouping: {
							units: [['day', [1]]]
						}
					}, {
						type: 'day',
						count: 7,
						text: 'Semaine',
						dataGrouping: {
							units: [['week', [1]]]
						}
					}, {
						type: 'month',
						count: 1,
						text: 'Mois',
						dataGrouping: {
							units: [['month', [1]]]
						}
					}],
					buttonTheme: {
						width: 60
					},
					selected: 1
				},
				/*
				title: {
				text: 'RUCHE <?php echo $rucheid ;?>'
				},
				*/
				legend: {
					enabled: true,
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0,
					itemDistance: 50
				},

				series: [
				{
					name: 'Poids',
					yAxis: 1,
					data: [<?php echo join($data_weight, ',') ?>]
				},
				{
					name: 'Humidité',

					data: [<?php echo join($data_humidity, ',') ?>]
				},
				{
					name: 'Temperature',
					yAxis: 0,
					data: [<?php echo join($data_temp, ',') ?>]
				}
				]


			}, function(chart){

				// apply the date pickers
				setTimeout(function(){
					$('input.highcharts-range-selector', $('#'+chart.options.chart.renderTo))
					.datepicker()
				},0)
			});
		});


		// Set the datepicker's date format
		$.datepicker.setDefaults({
			dateFormat: 'yy-mm-dd',
			onSelect: function(dateText) {
				this.onchange();
				this.onblur();
			}
		});

	});

	$(window).resize();

	$(function () {
		var gaugeOptions = {

			chart: {
				type: 'solidgauge'
			},

			title: null,

			pane: {
				center: ['50%', '85%'],
				size: '140%',
				startAngle: -90,
				endAngle: 90,
				background: {
					backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
					innerRadius: '60%',
					outerRadius: '100%',
					shape: 'arc'
				}
			},

			tooltip: {
				enabled: false
			},

			// the value axis
			yAxis: {
				stops: [
				[0.1, '#DF5353'], // green
				[0.5, '#DDDF0D'], // yellow
				[0.9, '#55BF3B'] // red
				],
				lineWidth: 0,
				minorTickInterval: null,
				tickAmount: 2,
				title: {
					y: -70
				},
				labels: {
					y: 16
				}
			},

			plotOptions: {
				solidgauge: {
					dataLabels: {
						y: 5,
						borderWidth: 0,
						useHTML: true
					}
				}
			}
		};


		// The speed gauge
		var chartSpeed = Highcharts.chart('containerspeed', Highcharts.merge(gaugeOptions, {
			yAxis: {
				min: 0,
				max: 70,
				title: {
					text: 'Poids'
				}
			},

			credits: {
				enabled: false
			},

			series: [{
				name: 'Speed',
				data: [0],
				dataLabels: {
					format: '<div style="text-align:center"><span style="font-size:25px;color:' +
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
					'<span style="font-size:12px;color:silver">Kg</span></div>'
				},
				tooltip: {
					valueSuffix: ' KG'
				}
			}]

		}));


		// Bring life to the dials
		setInterval(function () {
			// Speed
			var point,
			newVal;

			if (chartSpeed) {
				point = chartSpeed.series[0].points[0];
				newVal = <?php echo $moyenne24h ?>;

				point.update(newVal);
			}

		}, 2000);
	});




</script>