<?php
$servername = 'localhost';
$username = 'php';
$password = 'I@MTHEweb000';
$db_name = 'finance';
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);

$filter_cat = 'None';
$filter_begin_month = 'None';
$filter_end_month = 'None';
$query = $conn->query("SELECT Value FROM filters WHERE Type='Category'");
$filter_cat = $query->fetch_all()[0][0];
$query = $conn->query("SELECT Value FROM filters WHERE Type='Start Month'");
$filter_begin_month = $query->fetch_all()[0][0];
$query = $conn->query("SELECT Value FROM filters WHERE Type='End Month'");
$filter_end_month = $query->fetch_all()[0][0];
?>
