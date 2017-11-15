<!DOCTYPE HTML>
<html>
<head>
<?php
echo '<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,

	title:{
		text:"Top 20 products"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "#f2ece1",
		gridColor: "#f2ece1",
		title: "Time"
	},
	data: [{
		type: "bar",
		name: "products",
		axisYType: "secondary",
		color: "#f39c12",
		dataPoints: [
			{ y: 3, label: "Sweden" },
			{ y: 7, label: "Taiwan" },
			{ y: 5, label: "Russia" },
			{ y: 9, label: "Spain" },
			{ y: 7, label: "Brazil" },
			{ y: 7, label: "India" },
			{ y: 9, label: "Italy" },
			{ y: 8, label: "Australia" },
			{ y: 11, label: "Canada" },
			{ y: 15, label: "South Korea" },
			{ y: 12, label: "Netherlands" },
			{ y: 15, label: "Switzerland" },
			{ y: 25, label: "Britain" },
			{ y: 28, label: "Germany" },
			{ y: 29, label: "France" },
			{ y: 12, label: "Netherlands" },
			{ y: 15, label: "Switzerland" },
			{ y: 25, label: "Britain" },
			{ y: 28, label: "Germany" },
			{ y: 29, label: "France" }
		]
	}]
});
chart.render();

}
</script>';
    ?>
</head>
<body>
<div id="chartContainer" style="height: 600px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
