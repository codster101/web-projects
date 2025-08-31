<?php 
// Connect to DB
$servername = 'localhost';
$username = 'php';
$password = 'I@MTHEweb000';
$db_name = 'finance';
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);

// Getting all the filter values
$filter_cat = 'None';
$filter_begin_month = 'None';
$filter_end_month = 'None';
$query = $conn->query("SELECT Value FROM filters WHERE Type='Category'");
$filter_cat = $query->fetch_all()[0][0];
$query = $conn->query("SELECT Value FROM filters WHERE Type='Start Month'");
$filter_begin_month = $query->fetch_all()[0][0];
$query = $conn->query("SELECT Value FROM filters WHERE Type='End Month'");
$filter_end_month = $query->fetch_all()[0][0];

// Get purchases that match the category filter if there is one
if($filter_cat != 'None') {
	$result = mysqli_query($conn, "SELECT * FROM budget WHERE Category='{$filter_cat}'");
}
else {
	$result = mysqli_query($conn, "SELECT * FROM budget"); 
}

// Sort by month
$sorted = $result->fetch_all();
uasort($sorted, 'compMonths'); 

// Display the filters
echo "<h3>Filters</h3>";
echo "<pre>Category: {$filter_cat}		Start Month: {$filter_begin_month}	End Month: {$filter_end_month}</pre>";

// Display the total spent this month
GetTotalPurchasesThisMonth();

// Display the table
echo <<<EOT
	<div id="table">
		<table>
			<thead>
				<tr>
					<th scope="row">Name</th>
					<th scope="row">Amount</th>
					<th scope="row">Date</th>
					<th scope="row">Category</th>
					<th scope="row"></th>
				</tr>
			</thead>
			<tbody>

	EOT;
foreach($sorted as $row) {
	if(isValidDate($row[3], $filter_begin_month, $filter_end_month)) {
		printf(<<<EOT
				<tr>
					<th scope='row'>
						<form action='?submit_type=edit_table_name' method='POST' class='flex'>
							<input type='hidden' name='id' value='%d'/>
							<input class='shrink' type='text' name='val' value="%s"/>
							<input type='submit' value="change"/>
						</form>
					</th>
					<td>
						<form action='?submit_type=edit_table_amt' method='POST' class='flex'>
							<input type='hidden' name='id' value='%d'/>
							<input class='shrink' type='number' name='val' value="%.2f"/>
							<input type='submit' value="change"/>
						</form>
					</td>
					<td>
						<form action='?submit_type=edit_table_date' method='POST' class='flex'>
							<input type='hidden' name='id' value='%d'/>
							<input class='shrink' type='date' name='val' value="%s"/>
							<input type='submit' value="change"/>
						</form>
					</td>
					<td>
						<form action='?submit_type=edit_table_cat' method='POST' class='flex'>
							<input type='hidden' name='id' value='%d'/>
							<input class='shrink' type='text' name='val' value="%s"/>
							<input type='submit' value="change"/>
						</form>
					</td>
					<td>
						<form action='?submit_type=delete_row' method='POST' class='flex'>
							<input type='hidden' name='id' value='%d'/>
							<input type='submit' value="delete"/>
						</form>
					</td>
				</tr>\n
			EOT,
		$row[0], $row[1], $row[0], $row[2], $row[0], $row[3], $row[0], $row[4], $row[0]);
	}
}
echo <<<EOT
			</tbody>
		</table>
	</div>
EOT;

function GetTotalPurchasesThisMonth() {
	// Query for amounts 
	global $conn;
	$all_amounts = $conn->query("SELECT * FROM budget");

	// Add amounts with the correct month to an array
	$current_amounts = array();

	foreach($all_amounts->fetch_all() as $a){
		if(isValidDate($a[3], date('n', time()), date('n', time()))){
			array_push($current_amounts, $a[2]);
		}
	}

	// Get sum of all transactions for the current month
	$sum = array_sum($current_amounts);

	// Print to HTML
	echo "<p>Total for this month: {$sum}</p>";
}

function compMonths($a, $b) {
	$m1 = $a[3];
	$m2 = $b[3];
	if ($m1 == $m2) {
		return 0;
	}
	return ($m1 <$m2) ? -1 : 1;
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
