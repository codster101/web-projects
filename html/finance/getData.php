<?php
require 'get_filters.php';

// function getData($category, $start_month, $end_month) {
$servername = 'localhost';
$username = 'php';
$password = 'I@MTHEweb000';
$db_name = 'finance';

$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);

$col_1 = array("id" => "uniqueA", "label" => "Month", "type" => "string");
$col_2 = array("id" => "uniqueB", "label" => "Money Spent", "type" => "number");
$cols = array($col_1, $col_2);

if($filter_cat != 'None') {
	$result = $conn->query("SELECT * FROM budget WHERE Category='{$filter_cat}'");
}
else {
	$result = $conn->query("SELECT * FROM budget");
}

$months = array_fill(0, 12, 0);		// array from 0 to 12; 1 for each month
foreach($result->fetch_all() as &$a) {	// for each entry get the month and add the value to the corresponding month index
	if(isValidDate($a[3], $filter_begin_month, $filter_end_month)) {
		$month = getMonth($a[3]);
		$months[$month-1] += $a[2];
	}
}

$rows = array();
$index = 0;
foreach($months as &$m) {
	$r = array("c" => array(array("v" => $index+1), array("v" => $m)));
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
