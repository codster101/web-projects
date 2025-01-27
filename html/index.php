<?php require 'insert.php'?>
<!DOCTYPE html>
<html>
<head>
	<title> Finance </title>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="graph.js"></script>
</head>
<body>
	<?php
		echo 'Hello there<br/>';
		$servername = 'localhost';
		$username = 'php';
		$password = 'I@MTHEweb000';
		$db_name = 'finance';

		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);
		if($conn) {
			echo "Finally you did it<br/>";
		}
		else {
			echo "Connection Error!!";
		}
	?>
	<form action="" method="POST">
	
		<input type="text" id="name" name="name" required/>	
		<input type="decimal" step="0.01" id="amount" name="amount" required/>
		<input type="date" id="date" name="date" required/>
		<select id="category" name="category" required/>
		<option value="">Select One</option>
		<?php require 'generate-categories.php'; ?>

		<input type="submit" value="Add Entry"/>
	</form>
		<?php require 'display-table.php'; ?>
		<div id="chart_div"></div>
	</body>
</html>
