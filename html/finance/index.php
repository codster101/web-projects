<?php require 'generate-categories.php'; ?>
<?php require 'budget_amount.php';?>
<?php require 'insert.php';?>
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
	<form action="?submit_type=entry" method="POST">
	
		<input type="text" id="name" name="name" required/>	
		<input type="decimal" step="0.01" id="amount" name="amount" required/>
		<input type="date" id="date" name="date" required/>
		<select id="category" name="category" required>
			<option value="">Select One</option>
			<?php GetCategories(); ?>
		</select>

		<input type="submit" value="Add Entry"/>
	</form>
	<form action="?submit_type=filters" method="POST">
		<select id="category" name="filter_category">
			<?php GetCategories(); ?>
		</select>
		<select id="starting_month" name="filter_starting_month">
			<?php require 'month_select_options.php'?>
		</select>
		<select id="ending_month" name="filter_ending_month">
			<?php require 'month_select_options.php'?>
		</select>
		<input type="submit" value="Apply Filters"/>
	</form>

	<div id="chart_div"></div>

	<?php require 'display-table.php'; ?>

	<?php require 'category-divs.php'; ?>

	<?php foreach($categories as $cat => $amt): ?>
		<div class="cat_divs">
			<?php if($cat == "None") continue; ?>
			<p><?= $cat ?></p>
			<form action="?submit_type=budget_amount" method="POST">
				<input type="number" id="budget_amt" name="budget_amt"/>
				<input type="hidden" id="category" name="category" value="Groceries"/>
			</form>
			<p><?php DisplayBudgetStatus($cat);?></p>
		</div>
	<?php endforeach; ?>


</body>
</html>
