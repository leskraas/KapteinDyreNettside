<?php

include("../login_includes/db_connect.php");
include ("../login_includes/functions.php");

sec_session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset = "utf-8"/>
    <title> Kaptein Dyre</title>


    <?php
    include("includes/includer.php");
    $conn = connect();
    ?>



</head>

<body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="chart_div" style="width: 400px; height: 120px;"></div>
<script>
    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Memory', 80],
            ['CPU', 55],
            ['Network', 68]
        ]);

        var options = {
            width: 400, height: 120,
            redFrom: 90, redTo: 100,
            yellowFrom:75, yellowTo: 90,
            minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
            data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
            chart.draw(data, options);
        }, 13000);
        setInterval(function() {
            data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
            chart.draw(data, options);
        }, 5000);
        setInterval(function() {
            data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
            chart.draw(data, options);
        }, 26000);
    }
</script>



</body>


</html>