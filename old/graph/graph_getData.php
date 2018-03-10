<?php
/**
 * Created by PhpStorm.
 * User: larserikskraastad
 * Date: 09.03.2016
 * Time: 13.01
 */
//include ("../includes/connect_r.php");

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

//$mysqli = connect(); //henter en tilkobling til mysql databasen på serveren og legger den inn i mysqli variabelen




// ----------------------- Funksjon som henter data for temperatur -----------------------
function getData_all_temp(){
    global $mysqli; //henter den globale variabelen mysqli

    $result = $mysqli->query('SELECT SUBSTRING(servertime,12,5) AS servertime,temp_motor_nede,temp_motor_oppe,temp_lugar,temp_rom_bak,temp_vann FROM baat WHERE id > 2479');


    $rows = array();
    $table = array();
    $table['cols'] = array(

        array('label' => 'Datao', 'type' => 'string'),
        array('label' => 'Temperatur nede i motorrom', 'type' => 'number'),
        array('label' => 'Temperatur oppe i motorrom ', 'type' => 'number'),
        array('label' => 'Temperatur i lugaren', 'type' => 'number'),
        array('label' => 'Temperatur i lasterom', 'type' => 'number'),
        array('label' => 'Temperatur i vanntank', 'type' => 'number')

    );
    /* Extract the information from $result */
    foreach($result as $r) {

        $temp = array();

        // The following line will be used to slice the Pie chart

        $temp[] = array('v' => (string) $r['servertime']);

        // Values of the each slice

        $temp[] = array('v' => (int) $r['temp_motor_nede']);
        $temp[] = array('v' => (int) $r['temp_motor_oppe']);
        $temp[] = array('v' => (int) $r['temp_lugar']);
        $temp[] = array('v' => (int) $r['temp_rom_bak']);
        $temp[] = array('v' => (int) $r['temp_vann']);
        $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

    // convert data into JSON format
    $jsonTable = json_encode($table);


    return $jsonTable;
}                       //slutter funksjon getData_all_temp()





// ----------------------- Funksjon som henter siste data fra vannstand ------------------------------------------

function getData_water(){

    global $mysqli;

    $result = $mysqli->query('SELECT SUBSTRING(servertime,12,5) AS servertime,vannstand FROM baat WHERE id > 2479');


    $rows = array();
    $table = array();
    $table['cols'] = array(


        array('label' => 'Datao', 'type' => 'string'),
        array('label' => 'Vannstand', 'type' => 'number')

    );
    /* Extract the information from $result */
    foreach($result as $r) {

        $temp = array();

        // The following line will be used to slice the Pie chart

        $temp[] = array('v' => (string) $r['servertime']);

        // Values of the each slice

        $temp[] = array('v' => (int) $r['vannstand']);
        $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

    // convert data into JSON format
    $jsonTable = json_encode($table);

    return $jsonTable;
}                       //slutter funksjon getData_water()






// ----------------------- Funksjon som henter siste data fra alle temp og returnerer snittet -----------------------

function getData_last_temp_avg(){

    global $mysqli;

    $result = $mysqli->query('SELECT (temp_motor_nede + temp_motor_oppe + temp_lugar + temp_rom_bak + temp_vann)/5 AS temp  FROM baat ORDER BY id DESC LIMIT 1');
    $row = $result->fetch_assoc();
    return $row['temp']. " °C"; //returnerer siste snitt temperaturen
}







// ----------------------- Funksjon som henter siste data fra vannstand ------------------------------------------

function getData_last_water(){

    global $mysqli;

    $result = $mysqli->query('SELECT vannstand FROM baat ORDER BY id DESC LIMIT 1');
    $row = $result->fetch_assoc();
    return $row['vannstand']. " cm";
}






$mysqli ->close();



?>