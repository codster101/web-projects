<?php 

	$servername = 'localhost';
	$servername = 'localhost';
	$username = 'php';
	$password = 'I@MTHEweb000';
	$db_name = 'finance';

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);

	$result = mysqli_query($conn, "SELECT * FROM budget");

	echo '<table>';
	echo '<thead><tr><th scope="row">Name</th><th scope="row">Amount</th><th scope="row">Date</th><th scope="row">Category</th></tr></thead>';
	echo '<tbody>';
	while($row = mysqli_fetch_assoc($result)) {
		printf("<tr><th scope='row'>%s</th><td>%d</td><td>%s</td><td>%s</td></tr>\n", $row["Name"], $row["Amount"], $row["Date"], $row["Category"]);
	}
	echo '</tbody>';
	echo '</table>';
?>
