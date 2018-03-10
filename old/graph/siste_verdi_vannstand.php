<?php
$servername = "localhost";
$username = "readdb";
$password = "CcCturrzSZBw";
$dbname = "gruppe1";


/* Establish the database connection */
$mysqli = new mysqli($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* select all the weekly tasks from the table googlechart */
$result = $mysqli->query('SELECT vannstand FROM baat ORDER BY id DESC LIMIT 1');
$row = $result->fetch_assoc();
echo $row['vannstand']. " cm";
?>