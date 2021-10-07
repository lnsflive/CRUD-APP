<?php

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

//initialize

$username = "";
$email = "";

$errors = array();

//connect to db

DEFINE ('DB_USER', 'username');
DEFINE ('DB_PASSWORD', 'userpass');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'dbname');

$mysqli = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL ' .
		mysqli_connect_error());

$pdo = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL ' .
		mysqli_connect_error());

		
?>