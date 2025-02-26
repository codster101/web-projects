<?php
$servername = 'localhost';
$username = 'php';
$password = 'I@MTHEweb000';
$db_name = 'finance';

error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect('127.0.0.1', $username,$password, $db_name);
?>
