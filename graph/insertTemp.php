<?php
$servername = "localhost";
$username = "writedb1";
$password = "5yrUFS8cqhsd";
$dbname = "gruppe1";

$db = new mysqli($servername, $username, $password, $dbname);





$generateValuesString = function() {
    $string = "";
    $fullQuery = "";
    $tempDate = new DateTime();
    $tempDate->setDate(2016,04,01);
    $tempDate->setTime(00,00,00);
    $monthEkstra = 0;
    $dagerBort = 0;
    for($i = 0; $i < 2183; $i++) {

        if ($i > 720) {
            if ($i > 1464){
                $monthEkstra = 2;
                $dagerBort = 61; //Tar utgangspunkt i Apirl(30 dager) + mai(31 dager): 30+31= 61;
            } else {
                $monthEkstra = 1;
                $dagerBort = 30; //Tar utgangspunkt i Apirl (30 dager);
            }
        }


        if(($dagerEkstra = floor($i / 24) > 0)) {
            $tempDate->setDate(2016, 04 + $monthEkstra, (01 + $dagerEkstra)-$dagerBort);
        }
        $tempDate->setTime($i-$dagerEkstra*24,0,0);
        $timeStamp = $tempDate->getTimestamp();

        $temp1 = 10 * sin(2 * M_PI * $i / 24 + 13 * M_PI / 12) + 15 + rand( 0, 200)/100;
        $temp2 = 10 * sin(2 * M_PI * $i / 24 + 13 * M_PI / 12) + 12 + rand( 0, 100)/100;
        $temp3 = 10 * sin(2 * M_PI * $i / 24 + 13 * M_PI / 12) + 12 + rand( 0, 400)/100;
        $temp4 = 10 * sin(2 * M_PI * $i / 24 + 13 * M_PI / 12) + 12 + rand( 0, 300)/100;
        $temp5 = 10 * sin(2 * M_PI * $i / 24 + 13 * M_PI / 12) + 12 + rand( 0, 500)/100;
        $vann = 10 * sin(2 * M_PI * $i / 24 + 13 * M_PI / 12) + 12 + rand( 0, 10)/100;


        $string .= "(".$timeStamp.", ".$temp1.", ".$temp2.", ".$temp3.", ".$temp4.", ".$temp5.", ".$vann."),";
    }
    $string = rtrim($string, ",");
    $fullQuery = "INSERT INTO baat (timestamp, temp_motor_nede, temp_motor_oppe, temp_lugar, temp_rom_bak, temp_vann, vannstand) VALUES ".$string.";";

    echo $fullQuery;
    return $fullQuery;
};
/*
if($results = $db->query($generateValuesString())){ //Faktisk kjører kommandoen som legger inn data i database.
    echo "Success!";
}else {
    echo "The fullQuery didn't work:";
}
*/

$db ->close();
 ?>