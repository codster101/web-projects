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

	# echo "Server: <br/>";
	# foreach($_SERVER as $k => $v) {
		# echo "$k : $v <br>";
	# }
	# echo "End Server<br/>";
	# echo "Request: <br/>";
	# foreach($_REQUEST as $k => $v) {
		# echo "$k : $v <br>";
	# }
	# echo "End Request<br/>";
	if($_POST) { // && $_SERVER['submit']) {
		$name = $_POST['name'];
		$amt  = $_POST['amount'];
		$date  = $_POST['date'];
		$cat  = $_POST['category'];

//		echo $name . $amt . $date . $cat;	
		$query = mysqli_prepare($conn, 'INSERT INTO budget (name, amount, date, category) VALUES (?,?,?,?)');
		mysqli_stmt_bind_param($query, "sdss", $name, $amt, $date, $cat);
		mysqli_stmt_execute($query);
		// echo $query;
		$result = mysqli_query($conn, "SELECT * FROM budget");
		
		header("Location: ", $_SERVER["PHP_SELF"]);
		exit;	
	}
?>
