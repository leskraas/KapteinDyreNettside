<?php

//Funksjonen "connect" returnerer en tilkobling til mysql databasen på serveren

function connect(){

	$servername = "localhost";
	$username = "readdb";
	$password = "";
	$dbname = "gruppe1";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if(!$conn){
		echo"Did not connect";
		return 0;
	}else{

	return $conn;
	
	}
}

?>
