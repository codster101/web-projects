<?php
require 'get_filters.php';
// require 'generate-categories.php';

function DisplayBudgetStatus($c) {
	// query db for all transactions this month in given category
	$spent = GetPurchasesInCurrentMonth($c);

	// Get the amount budgeted
	$budgeted = GetBudgetForCategory($c);

	// display budgeted - spent
	echo "Budgeted: " . $budgeted . "<br>";
	echo "Spent: " . $spent . "<br>";
	echo "Remaining: " . $budgeted - $spent;
}

function GetPurchasesInCurrentMonth($c) {
	require 'connect_to_db.php';
	$result = $conn->query("SELECT * FROM budget WHERE Category='{$c}'");
	//	$m = GetCurrentMonth();
	$m = GetCurrentMonth();
	$spent = 0;
	while ($r = $result->fetch_assoc()) {
		if(GetMonthFromDate($r["Date"]) == $m){
			$spent += $r["Amount"];
		}
	}
	return $spent;
}

function GetbackgroundColor($c) {
	if(GetBudgetForCategory($c) - GetPurchasesInCurrentMonth($c) > 0) {
		return '"' . "background-color: green" . '"';
	}
	else if(GetBudgetForCategory($c) - GetPurchasesInCurrentMonth($c) < 0) {
		return '"' . "background-color: red" . '"';
	}
}

function GetCurrentMonth() {
	$now = time();
	return date('n', $now);
}

function GetMonthFromDate($d) {
return date('n', strtotime($d));
}

?>
