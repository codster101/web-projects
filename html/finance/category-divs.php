<?php
require 'get_filters.php';
// require 'generate-categories.php';

function DisplayBudgetStatus($c) {
	// query db for all transactions this month in given category
	$spent = GetPurchasesInCurrentMonth($c);

	// Get the amount budgeted
	$budgeted = GetBudgetForCategory($c);

	// display budgeted - spent
	echo $budgeted . "<br>";
	echo $spent . "<br>";
	echo $budgeted - $spent;
}

function GetPurchasesInCurrentMonth($c) {
	require 'connect_to_db.php';
	$result = $conn->query("SELECT * FROM budget WHERE Category='{$c}'");
	//	$m = GetCurrentMonth();
	$m = 01;
	$spent = 0;
	while ($r = $result->fetch_assoc()) {
		if(GetMonthFromDate($r["Date"]) == $m){
			$spent += $r["Amount"];
		}
	}
	return $spent;
}

function GetCurrentMonth() {
	$now = time();
	return date('n', $now);
}

function GetMonthFromDate($d) {
return date('n', strtotime($d));
}

?>
