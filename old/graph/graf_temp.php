<?php

include "../includes/connect_r.php";
$mysqli = connect();

/* select all the weekly tasks from the table googlechart */
$result = $mysqli->query('SELECT SUBSTRING(servertime,12,5) AS servertime,temp_motor_nede,temp_motor_oppe,temp_lugar,temp_rom_bak,temp_vann FROM baat WHERE id > 2479');


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
//echo $jsonTable;


?>


<html>
<head>
    <!--Load the Ajax API
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        function drawChart() {

            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(<?=$jsonTable?>);
            var options = {
                curveType: 'function',
                backgroundColor:"none",
                vAxis:{
                    gridlines: {
                        color: ' '
                    },
                    baselineColor: ' '
                },
                legend: {
                    position:'right'
                }
            };
            // Instantiate and draw our chart, passing in some options.
            // Do not forget to check your div ID
            var chart = new google.visualization.LineChart(document.getElementById('chart_div_temp'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
<!--this is the div that will hold the pie chart-->
<div id="chart_div_temp"></div>
</body>
</html>