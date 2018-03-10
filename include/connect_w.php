<?php

//Funksjonen "connect" returnerer en tilkobling til mysql databasen på serveren

function connect_1(){

	$servername = "localhost";
	$username = "writedb1";
	$password = "5yrUFS8cqhsd";
	$dbname = "gruppe1";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if(!$conn){
		echo"Did not connect <br>";
		return 0;
	}
	else{

	return $conn;
	
	}
}

?>
