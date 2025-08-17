<?php 

// Gets the budgeted amount for the inputted category
// Category must be in the data table (input comes from category.txt)
// Budgeted amount set by the input field
function GetBudgetForCategory($c) {
	global $conn;
	$result = $conn->query("SELECT Amount FROM budget_amounts WHERE Category='{$c}'");
	return $result->fetch_assoc()["Amount"]; 
}

// Sets the budget amount of Category $c to amount $a
// Stores in mysql table budget_amounts
function SetBudgetOfCategory($c, $a) {
	global $conn;
	$result = $conn->query("UPDATE budget_amounts SET Amount={$a} WHERE Category='{$c}'");
}

?>
