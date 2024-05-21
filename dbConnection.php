<?php
$databaseHost = 'localhost';
$databaseName = 'db_20634982';
$databaseUsername = '20634982';
$databasePassword = 'webtech1@#';

// $databaseHost = 'localhost';
// $databaseName = 'bookreview';
// $databaseUsername = 'root';
// $databasePassword = '';

// Open a new connection to the MySQL server
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
