<?php
include("../login_includes/db_connect.php");
include ("../login_includes/functions.php");
sec_session_start();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>Båtvakten</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    include "include/cssStyle.php";
    include 'graph/getGraph_temp_vann.php';
    ?>

    <link rel="stylesheet" type="text/css" href="include/mainStyle.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">





</head>

<?php if(login_check($mysqli) == "gruppe1") :/* VIKTIG! Alt som kommer etter denne kodelinja må man være innlogget for å  se*/ ?>

<body>

<div id="nav-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="index.php">Båtvakten</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
            <ul class="nav navbar-nav navbar-right">
                <li ><a href="index.php" data-toggle="tooltip" title="Hjem"><img src="Bilder/hjem.png" style="width: 33px" alt="Hjem"></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="Bilder/temp1.png" style="width: 33px" alt="Temperatur"> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="temperatur.php">Alle Temeperaturer</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="temperatur_motor_oppe.php">Temperatur oppe i motorrom</a></li>
                        <li><a href="temperatur_motor_nede.php">Temperatur nede i motorrom</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="temperatur_lugar.php">Temperatur i lugar</a></li>
                        <li><a href="temperatur_rom_bak.php">Temperatur i lasterom</a></li>
                        <li><a href="temperatur_vann.php">Temperatur i vanntank</a></li>

                    </ul>
                </li>
                <li><a href="vann.php" data-toggle="tooltip" title="Vannstand"><img src="Bilder/waterIcon.png" style="width: 33px"></a></li>
                <li><a href="../login_includes/logout.php" data-toggle="tooltip" title="Logg ut"><img src="Bilder/loggut.png" style="width: 33px"></a></li>
            </ul>
        </div>
    </div>
</div>


<div id="dashboard" style="text-align: center; width: 90%; margin: 70px 0 70px 0;">
    <div id="chart_div_temperatur_stor" style="text-align: center; width: 100%; height: 500px;"></div>
    <div id="control_div" style="text-align: center; width: 100%; height: 100px;"></div>
</div>
<!--<div id=test3_chart style="margin-top: 100px;">Please wait...</div>-->

<!--<div id="chart_temp" style="text-align: center; width: 90%; height: 800px; margin: -100px 0 0 0;"></div>-->






<div class="container text-center">
    <div class="row">
        <div class="col-sm-6">
            <div class="container_vann_2">
                <div class="row">
                    <div class="col-xs-8">
                        <div id="chart_vann_liten" style="width: 100%; height: 150px; float: left;"></div>
                    </div>
                    <div class="col-lg-4">
                        <a href="vann.php"><span class="center_tekst_snitt_2"><?php echo $vann_siste ?>cm</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="container_temp_2">
                <div class="row">
                    <div class="col-xs-8">
                        <div id="chart_temp_liten" style="width: 100%; height: 150px; float: left;"></div>
                    </div>
                    <a href="#" style="width: 100%">
                        <div class="col-lg-4">
                            <a href="temperatur.php"> <span class="center_tekst_snitt_2"><?php echo $temp_snitt_siste ?>C˚</span> </a>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>




<footer class="container-fluid text-center">
    <p>Copyright © 2016 Båtvakten</p>
</footer>


<?php else :?>
    <h1 style="font-family: Lato; font-weight: 100; text-align: center">Du er ikke lenger logget inn</h1>
    <form action="../login_includes/logout.php" style="text-align: center">
        <input type="submit" value="Logg inn på nytt!">
    </form>
<?php endif; ?>



</body>
</html>
