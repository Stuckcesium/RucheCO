<script type="text/javascript">
var lineargauge = Highcharts.chart('hausse', {

	chart: {
		renderTo: 'hausse',
    	marginLeft: 70,
        marginRight: 70,
        plotBorderWidth: 1,
        plotBackgroundColor: '#DDDDDD'
    },

	title: null,
    
    credits: {
    	enabled: false
    },

    xAxis: {
        visible: false
    },
    
    yAxis: {
    	min: 0,
        max: 100,
        opposite: true,
        tickInterval: 10,
        tickWidth: 1,
        tickLength: 10,
        gridLineWidth: 0,
        minorTickWidth: 1,
        minorTickLength: 5,
        minorTickInterval: 2,
        minorGridLineWidth: 0,
        offset: 3,
        title: {
        	text: null
        }
    },

    series: [{
        data: [18],
        type: 'column',
        showInLegend: false,
        dataLabels: {
        	enabled: true
        },
        pointPadding: 0,
        groupPadding: 0,
        borderWidth: 0,
        color: 'green'
    }]

});
</script>