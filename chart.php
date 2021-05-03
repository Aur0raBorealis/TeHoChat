<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>
		TeHoChat
	</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="css/hrv.css" rel="stylesheet"/>
	
</head>
<body>




<div id="header-wrapper">
	<div id="header" class="container">
		<div id="logo">
			<span class="icon icon-group"></span>
			<h1>
				<a href="index.php">
					TeHoChat
				</a>
			</h1>
			<?php
				include("includes/iheader.php");

			?>
		</div>
		<div id="triangle-up">		
		</div>
	</div>
</div>
<div id="menu-wrapper">
		<div id="menu">
			<ul>
				<li><a href="userChat.php" accesskey="2" title="">Aloita chat</a></li>
				<li><a href="chart.php" accesskey="3" title="">HRV</a></li>
				<li><a href="asetukset.php" accesskey="5" title="">Asetukset</a></li>
			</ul>
		</div>
</div>


<style>

#graph1
{
margin: auto;
color: white;

}


</style>


<div id="graph1">
<h2> ESIMERKKI VIIKON STRESSITASOSTA </h2>
</div>



</body>
</html>




<!-- Styles -->
<style>
#chartdiv {
  width: 75%;
  height: 500px;
  margin: auto;
}

</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>

fetch('https://users.metropolia.fi/~tapiky/TeHoChat/api/hrv3.php')
  .then((response) => {
	return response.json();
  })
  .then((data) => {   
	console.log(data);
	 





// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart
var chart = am4core.create("chartdiv", am4charts.XYChart);
chart.paddingRight = 20;



chart.data = data;
chart.dateFormatter.inputDateFormat = "yyyy";

var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.minGridDistance = 50;
dateAxis.baseInterval = {timeUnit:"year", count:1};

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.tooltip.disabled = true;

var series = chart.series.push(new am4charts.StepLineSeries());
series.dataFields.dateX = "year";
series.dataFields.valueY = "value";
series.tooltipText = "{valueY.value}";
series.strokeWidth = 3;

chart.cursor = new am4charts.XYCursor();
chart.cursor.xAxis = dateAxis;
chart.cursor.fullWidthLineX = true;
chart.cursor.lineX.strokeWidth = 0;
chart.cursor.lineX.fill = chart.colors.getIndex(2);
chart.cursor.lineX.fillOpacity = 0.1;

chart.scrollbarX = new am4core.Scrollbar();

});
</script>


<!-- HTML -->
<div id="chartdiv"></div>
