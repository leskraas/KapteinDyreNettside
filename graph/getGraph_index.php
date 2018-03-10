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


/* select all the weekly tasks from the table googlechart */
$result_siste = $abs->query('SELECT FROM_UNIXTIME(timestamp) AS servertime,temp_motor_nede,temp_motor_oppe,temp_lugar,temp_rom_bak,temp_vann,vannstand FROM baat ORDER BY id DESC LIMIT 1');

$row_siste = $result_siste->fetch_array(MYSQLI_ASSOC); //henter siste verdier og legger inn i en array

$temp_motor_nede_siste = $row_siste["temp_motor_nede"];
$temp_motor_oppe_siste = $row_siste["temp_motor_oppe"];
$temp_lugar_siste = $row_siste["temp_lugar"];
$temp_rom_bak_siste = $row_siste["temp_rom_bak"];
$temp_vann_siste = $row_siste["temp_vann"];
$vann_siste = number_format($row_siste["vannstand"],1);
$dato_siste = $row_siste["servertime"];

$result_temp_snitt_siste = $abs->query('SELECT (temp_motor_nede + temp_motor_oppe + temp_lugar + temp_rom_bak + temp_vann)/5 AS temp  FROM baat ORDER BY id DESC LIMIT 1');
$row_temp_snitt_siste = $result_temp_snitt_siste->fetch_array(MYSQLI_ASSOC);
$temp_snitt_siste = number_format($row_temp_snitt_siste["temp"],1);








$result_temp_snitt_liten = $abs->query('SELECT SUBSTRING(FROM_UNIXTIME(timestamp),12,5) AS servertime, (temp_motor_nede + temp_motor_oppe + temp_lugar + temp_rom_bak + temp_vann)/5 AS temp FROM baat ORDER BY id DESC LIMIT 10');

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







$result_vann_liten = $abs->query('SELECT SUBSTRING(FROM_UNIXTIME(timestamp),12,5) AS servertime,vannstand FROM baat ORDER BY id DESC LIMIT 10');

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

    google.charts.load('current', {
        'packages': ['gauge','corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data_temp_lugar = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Temp', <?php echo $temp_lugar_siste; ?>]

        ]);

        var data_temp_motor_oppe = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Temp', <?php echo $temp_motor_oppe_siste; ?>]

        ]);

        var data_temp_motor_nede = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Temp', <?php echo $temp_motor_nede_siste; ?>]]);


        var data_temp_rom_bak = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Temp', <?php echo $temp_rom_bak_siste; ?>]

        ]);

        var data_temp_vann = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Temp', <?php echo $temp_vann_siste; ?>]

        ]);


        var data_vann_gauge = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Vann', <?php echo $vann_siste; ?>]
        ]);





        var data_vann_liten = new google.visualization.DataTable(<?=$jsonTable_vann_liten?> );

        var data_temp_liten = new google.visualization.DataTable(<?=$jsonTable_temp_snitt_liten?>);






        var options_temp_liten = {
            redColor: '#e36041',
            redFrom: 50,
            redTo: 60,
            yellowColor: '#0066FF',
            yellowFrom: -30,
            yellowTo: -5,
            greenFrom: 0,
            greenTo: 38,
            minorTicks: 20,
            majorTicks: ['-30', '60'],
            min: -30,
            max: 60
        };


        var options_vann_liten = {
            yellowFrom: 15,
            yellowTo: 20,
            redColor: '#e36041',
            redFrom: 20,
            redTo: 30,
            minorTicks: 20,
            majorTicks: ['0', '30'],
            min: 0,
            max: 30
        };


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


        var chart_vann_liten = new google.visualization.LineChart(document.getElementById('chart_vann_liten'));
        chart_vann_liten.draw(data_vann_liten, options_liten_vann);

        var chart_temp_liten = new google.visualization.LineChart(document.getElementById('chart_temp_liten'));
        chart_temp_liten.draw(data_temp_liten, options_liten_temp);


        var chart_temp_lugar = new google.visualization.Gauge(document.getElementById('chart_temp_lugar'));
        chart_temp_lugar.draw(data_temp_lugar, options_temp_liten);

        var chart_temp_motor_oppe = new google.visualization.Gauge(document.getElementById('chart_temp_motor_oppe'));
        chart_temp_motor_oppe.draw(data_temp_motor_oppe, options_temp_liten);

        var chart_temp_motor_nede = new google.visualization.Gauge(document.getElementById('chart_temp_motor_nede'));
        chart_temp_motor_nede.draw(data_temp_motor_nede, options_temp_liten);

        var chart_temp_rom_bak = new google.visualization.Gauge(document.getElementById('chart_temp_rom_bak'));
        chart_temp_rom_bak.draw(data_temp_rom_bak, options_temp_liten);

        var chart_temp_vann = new google.visualization.Gauge(document.getElementById('chart_temp_vann'));
        chart_temp_vann.draw(data_temp_vann, options_temp_liten);

        var chart_vann_gauge = new google.visualization.Gauge(document.getElementById('chart_vann_gauge'));
        chart_vann_gauge.draw(data_vann_gauge, options_vann_liten);



    }
    $(window).resize(function(){
        drawChart();
    });
</script>

