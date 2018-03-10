<?php
$servername = "localhost";
$username = "readdb";
$password = "CcCturrzSZBw";
$dbname = "gruppe1";


/* Establish the database connection */
$abs = new mysqli($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


$result_siste = $abs->query('SELECT vannstand FROM baat ORDER BY id DESC LIMIT 1');
$row_siste = $result_siste->fetch_array(MYSQLI_ASSOC); //henter siste verdier og legger inn i en array
$vann_siste = number_format($row_siste["vannstand"], 1);




$result_temp_snitt_siste = $abs->query('SELECT (temp_motor_nede + temp_motor_oppe)/2 AS temp  FROM baat ORDER BY id DESC LIMIT 1');
$row_temp_snitt_siste = $result_temp_snitt_siste->fetch_array(MYSQLI_ASSOC);
$temp_snitt_siste = number_format($row_temp_snitt_siste["temp"],1);




/* select all the weekly tasks from the table googlechart */
$result_temp = $abs->query('SELECT * FROM (SELECT id, FROM_UNIXTIME(timestamp) as timestamp, temp_vann FROM baat ORDER BY id DESC LIMIT 300) a ORDER BY id ASC');

$rows_temp = array();
$table_temp = array();
$table_temp['cols'] = array(

    array('label' => 'Dato', 'type' => 'datetime'),
    array('label' => 'Temperatur i vanntank', 'type' => 'number')

);
/* Extract the information from $result */
foreach($result_temp as $r_temp) {
    //echo $r_temp['servertime']. "\n";
    $temp_temp = array();
    /*$date = new DateTime();
    $date->setTimestamp($r_temp['servertime']);
    echo $date->format('H:i:s'). "\n";

    $temp_temp[] = array('v' => $date->format('H:i:s')); //(int) ($r_temp['servertime'])*/
    preg_match('/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/', $r_temp['timestamp'], $match);
    $year = (int) $match[1];
    $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
    $day = (int) $match[3];
    $hours = (int) $match[4];
    $minutes = (int) $match[5];
    $seconds = (int) $match[6];
    $temp_temp[] = array('v' => "Date($year, $month, $day, $hours, $minutes, $seconds)");


    // Values of the each slice

    $temp_temp[] = array('v' => (int) $r_temp['temp_vann']);
    $rows_temp[] = array('c' => $temp_temp);
}

$table_temp['rows'] = $rows_temp;

// convert data into JSON format
$jsonTable_temp = json_encode($table_temp, true);





$result_temp_snitt_liten = $abs->query('SELECT SUBSTRING(servertime,12,5) AS servertime, (temp_motor_nede + temp_motor_oppe)/2 AS temp FROM baat ORDER BY id DESC LIMIT 10');

$rows_temp_snitt_liten = array();
$table_temp_snitt_liten = array();
$table_temp_snitt_liten['cols'] = array(

    array('label' => 'Datao', 'type' => 'string'),
    array('label' => 'Temp', 'type' => 'number')
);
/* Extract the information from $result */
foreach($result_temp_snitt_liten as $r_temp_snitt_liten) {

    $temp_temp_snitt_liten = array();
    $temp_temp_snitt_liten[] = array('v' => (string) $r_temp_snitt_liten['servertime']);
    $temp_temp_snitt_liten[] = array('v' => (int) $r_temp_snitt_liten['temp']);
    $rows_temp_snitt_liten[] = array('c' => $temp_temp_snitt_liten);
}

$table_temp_snitt_liten['rows'] = $rows_temp_snitt_liten;

// convert data into JSON format
$jsonTable_temp_snitt_liten = json_encode($table_temp_snitt_liten, true);







$result_vann_liten = $abs->query('SELECT SUBSTRING(servertime,12,5) AS servertime,vannstand FROM baat ORDER BY id DESC LIMIT 10');

$rows_vann_liten = array();
$table_vann_liten = array();
$table_vann_liten['cols'] = array(

    array('label' => 'Datao', 'type' => 'string'),
    array('label' => 'Vannstand', 'type' => 'number')

);
/* Extract the information from $result */
foreach($result_vann_liten as $r_vann_liten) {

    $temp_vann_liten = array();

    $temp_vann_liten[] = array('v' => (string) $r_vann_liten['servertime']);
    $temp_vann_liten[] = array('v' => (int) $r_vann_liten['vannstand']);
    $rows_vann_liten[] = array('c' => $temp_vann_liten);
}

$table_vann_liten['rows'] = $rows_vann_liten;

// convert data into JSON format
$jsonTable_vann_liten = json_encode($table_vann_liten, true);



$abs ->close();
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.load('visualization', '1', {packages: ['corechart', 'controls']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable_temp?>);

        var data_vann_liten = new google.visualization.DataTable(<?=$jsonTable_vann_liten?> );

        var data_temp_liten = new google.visualization.DataTable(<?=$jsonTable_temp_snitt_liten?>);

        var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard'));


        var slider = new google.visualization.ControlWrapper({
            'controlType': 'ChartRangeFilter',
            'containerId': 'control_div',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'chartOptions': {
                        'chartArea': {
                            'width': '80%'
                        },
                        'backgroundColor':"none"
                    },
                    'chartView': {
                        'columns': [0, 1]
                    }
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'LineChart',
            'containerId': 'chart_div_temperatur_stor',
            'options': {
                'backgroundColor':"none",
                'series': {
                    0: {
                        color: '#b300b3'
                    }
                }
            }
        });

        var options_liten_vann = {
            curveType: 'function',
            colors: ['#00b2ee'],
            backgroundColor:"#e4ecee",
            vAxis:{
                gridlines: {
                    color: 'none'
                },
                baselineColor: 'none',
                textStyle:{
                    fontSize: 12,
                    color: 'black'
                }
            },
            hAxis:{
                textStyle:{
                    color: 'black'
                },
                direction: -1,
                slantedText: true,
                slantedTextAngle: 40
            },
            legend: {
                position:'top',
                alignment: 'center',
                textStyle:{
                    fontSize: 16
                }
            }
        };

        var options_liten_temp = {
            curveType: 'function',
            colors: ['#8ccd64'],
            backgroundColor: "#e4ecee",
            vAxis: {
                gridlines: {
                    color: 'none'
                },
                baselineColor: 'none',
                textStyle: {
                    fontSize: 12,
                    color: 'black'
                }
            },
            hAxis: {
                textStyle: {
                    color: 'black'
                },
                direction: -1,
                slantedText: true,
                slantedTextAngle: 40
            },
            legend: {
                position: 'top',
                alignment: 'center',
                textStyle: {
                    fontSize: 16
                }
            }
        };

        dashboard.bind(slider, chart);
        dashboard.draw(data);

        var chart_vann_liten = new google.visualization.LineChart(document.getElementById('chart_vann_liten'));
        chart_vann_liten.draw(data_vann_liten, options_liten_vann);

        var chart_temp_liten = new google.visualization.LineChart(document.getElementById('chart_temp_liten'));
        chart_temp_liten.draw(data_temp_liten, options_liten_temp);


    }
    $(window).resize(function(){
        drawChart();
    });
</script>