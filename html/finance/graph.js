google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	var jsonData = $.ajax({
		url: "getData.php",
		dataType: "json",
		async: false, 
		}).responseText;

	var data = new google.visualization.DataTable(jsonData);

	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	chart.draw(data);
}
