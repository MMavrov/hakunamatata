<?php 
// Connects to Our Database

	// Initialize connection variables
	$host     = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'phpsocialnetworkdb';

	// Connect to Database
	$pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);

?> 
