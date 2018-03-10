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
$result = $mysqli->query('SELECT (temp_motor_nede + temp_motor_oppe + temp_lugar + temp_rom_bak + temp_vann)/5 AS temp  FROM baat ORDER BY id DESC LIMIT 1');
$row = $result->fetch_assoc();
echo $row['temp']. " °C";
?>
