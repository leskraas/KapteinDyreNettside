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
$result = $mysqli->query('SELECT SUBSTRING(servertime,12,5) AS servertime, (temp_motor_nede + temp_motor_oppe + temp_lugar + temp_rom_bak + temp_vann)/5 AS temp FROM baat WHERE id > 2491');


$rows = array();
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles.
    /*
        note that one column is in "string" format and another one is in "number" format
        as pie chart only required "numbers" for calculating percentage
        and string will be used for Slice title
    */

    array('label' => 'Datao', 'type' => 'string'),
    array('label' => 'Temp', 'type' => 'number')

);
/* Extract the information from $result */
foreach($result as $r) {

    $temp = array();

    // The following line will be used to slice the Pie chart

    $temp[] = array('v' => (string) $r['servertime']);

    // Values of the each slice

    $temp[] = array('v' => (int) $r['temp']);

    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;

// convert data into JSON format
$jsonTable = json_encode($table);
//echo $jsonTable;


?>


<html>
<head>
    <!--Load the Ajax API
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1',  {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        function drawChart() {

            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(<?=$jsonTable?>);
            var options = {
                curveType: 'function',
                backgroundColor:"#cef2b7",
                vAxis:{
                    gridlines: {
                        color: 'none'
                    },
                    baselineColor: '#F0F0F0'
                },
                legend: {
                    position:'none'
                }
            };
            // Instantiate and draw our chart, passing in some options.
            // Do not forget to check your div ID
            var chart = new google.visualization.LineChart(document.getElementById('chart_div_temp_liten'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
<!--this is the div that will hold the pie chart-->
<div id="chart_div_temp_liten"></div>
</body>
</html>