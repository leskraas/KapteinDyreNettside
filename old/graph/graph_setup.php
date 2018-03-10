<?php
include "graph_getData.php"
?>



<script type="text/javascript">


        // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart_water);//



        //------------------------------------- lager graf for vann ---------------------------------------
    function drawChart_water() {

        <?$jsonTable = getData_water();?>


        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(<?=$jsonTable?>);
        var options = {
            title: 'Vannstand',
            titleTextStyle: {fontSize: 25,bold: false},
            //width: 800,
            //height: 600,
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
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_water'));
        chart.draw(data, options);
    }






</script>


