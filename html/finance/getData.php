<?php
require 'get_filters.php';
require 'budget_amount.php';
require 'generate-categories.php';


// Connect to DB
$servername = 'localhost';
$username = 'php';
$password = 'I@MTHEweb000';
$db_name = 'finance';

$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);
//------------------------------------------------

$col_1 = array("id" => "uniqueA", "label" => "Month", "type" => "string");
$col_2 = array("id" => "uniqueB", "label" => "Spent", "type" => "number");
$col_3 = array("id" => "uniqueC", "label" => "Earned", "type" => "number");
$col_4 = array("id" => "uniqueC", "label" => "Budgeted", "type" => "number");
$cols = array($col_1, $col_2, $col_3, $col_4);

if($filter_cat != 'None') {
	$result = $conn->query("SELECT * FROM budget WHERE Category='{$filter_cat}'");
}
else {
	$result = $conn->query("SELECT * FROM budget");
}

// Line - Spent
// Getting purchase amounts and sorting by month
$months = array_fill(0, 12, array("spent" => 0,"earned" => 0));		// array from 0 to 12; 1 for each month
foreach($result->fetch_all() as &$a) {	// for each entry get the month and add the value to the corresponding month index
	if(isValidDate($a[3], $filter_begin_month, $filter_end_month) && $a[4] != "Income") {
		$month = getMonth($a[3]);
		$months[$month-1]["spent"] += $a[2];
	}
}

// Line - Earned
// Getting amount earned for each month and sorting by month
$result = $conn->query("SELECT * FROM budget");
foreach($result->fetch_all() as &$a) {	// for each entry get the month and add the value to the corresponding month index
	if(isValidDate($a[3], $filter_begin_month, $filter_end_month) && $a[4] == "Income") {
		$month = getMonth($a[3]);
		$months[$month-1]["earned"] += $a[2];
	}
}

// Line - Budgeted
// For all categories in filter add their budgets
$a = 0;
if($filter_cat != 'None') {
	$a = GetBudgetForCategory($filter_cat);
}
else {
	foreach($categories as $c => $b) {
		$a += GetBudgetForCategory($c);
	}
}

// Column is a pair of two values month and money spent
$rows = array();
$index = 0;
foreach($months as &$m) {
	$r = array("c" => array(array("v" => $index+1), array("v" => $m["spent"]), array("v" => $m["earned"]), array("v" => $a)));
	array_push($rows, $r);
	$index++;
}

$json = json_encode(array("cols" => $cols, "rows" => $rows));
echo $json;
// }

function getMonth($month_string) {
	$begining = strpos($month_string, '-');
	$month = substr($month_string, $begining + 1, 2);
	return $month;
}

function isValidDate ($date_string, $begin_month, $end_month) {
	if($begin_month == 'None' && $end_month == 'None') { return true;}
	$begining = strpos($date_string, '-');
	$month = substr($date_string, $begining + 1, 2);
	//	echo $ss . " ";
	if($month >= intval($begin_month) && $month <= intval($end_month)) {return true;}	
	return false;

}
?>
