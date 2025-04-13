<?php 


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
if($_POST && $_REQUEST['submit_type'] == 'entry') { // && $_SERVER['submit']) {
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

// var_dump($_POST);
// echo "</br>";
// var_dump($_REQUEST);
if($_POST && $_REQUEST['submit_type'] == 'filters') {
	$servername = 'localhost';
	$username = 'php';
	$password = 'I@MTHEweb000';
	$db_name = 'finance';
	$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);

	$filter_begin_month = $_POST['filter_starting_month'];
	$filter_end_month = $_POST['filter_ending_month'];
	$filter_category = $_POST['filter_category'];

	mysqli_query($conn, "UPDATE filters SET Value = '{$filter_begin_month}' WHERE Type = 'Start Month'");
	mysqli_query($conn, "UPDATE filters SET Value = '{$filter_end_month}' WHERE Type = 'End Month'");
	mysqli_query($conn, "UPDATE filters SET Value = '{$filter_category}' WHERE Type = 'Category'");
	header("Location: ", $_SERVER["PHP_SELF"]);
	exit;	
}

if($_POST && $_REQUEST['submit_type'] == 'budget_amount') {
	$category = $_POST['category'];
	$budget_amt = $_POST['budget_amt'];
	SetBudgetOfCategory($category, $budget_amt);
	header("location: ", $_SERVER["PHP_SELF"]);
	exit;
}
?>
