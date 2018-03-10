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
    include 'graph/getGraph_index.php';
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





<div class="img-responsive">
    <img src="Bilder/Baat3d2.png">
    <div id="temp_lugar" >
        <a href="temperatur_lugar.php"><div id="chart_temp_lugar"></div> </a>
    </div>
    <div id="temp_motor_oppe" >
        <a href="temperatur_motor_oppe.php"> <div id="chart_temp_motor_oppe"></div> </a>
    </div>
    <div id="temp_motor_nede">
        <a href="temperatur_motor_nede.php"> <div id="chart_temp_motor_nede"></div> </a>
    </div>
    <div id="temp_rom_bak">
        <a href="temperatur_rom_bak.php"> <div id="chart_temp_rom_bak"></div> </a>
    </div>
    <div id="temp_vann">
        <a href="temperatur_vann.php"> <div id="chart_temp_vann"></div> </a>
    </div>
    <div id="vann_gauge">
        <a href="vann.php"> <div id="chart_vann_gauge"></div> </a>
    </div>
</div>






<div class="container text-center">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <div  class="container_siste_oppdatering">
                    <div class="center_tekst_siste_oppdatering">
                        Siste oppdatering var:<br>
                        <?php echo $dato_siste ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container_vann">
                    <div class="row">
                        <div class="col-xs-8">
                            <div id="chart_vann_liten"></div>
                        </div>
                        <div class="col-lg-4">
                            <a href="vann.php"><div class="center_tekst_snitt"><?php echo $vann_siste ?>cm</div></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  class="container_temp">
                    <div class="row">
                        <div class="col-xs-8">
                            <div id="chart_temp_liten"></div>
                        </div>
                        <div class="col-lg-4">
                            <a href="temperatur.php"> <div class="center_tekst_snitt"><?php echo $temp_snitt_siste ?>C˚</div> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="row">
                <div  id="boks_temp_motor_nede">
                    <div class="row">
                        <div class="col-xs-6" >
                            <div class="center_tekst">
                                Temperatur nede i motorrom
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="center_glyphicon">
                                <span class="glyphicon glyphicon-ok" style="font-size: 200%"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  id="boks_temp_motor_oppe">
                    <div class="row">
                        <div class="col-xs-6" >
                            <div class="center_tekst">
                                Temperatur oppe i motorrom
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="center_glyphicon">
                                <span class="glyphicon glyphicon-ok" style="font-size: 200%"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  id="boks_temp_vann">
                    <div class="row">
                        <div class="col-xs-6" >
                            <div class="center_tekst">
                                Temperatur i vanntank
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="center_glyphicon">
                                <span class="glyphicon glyphicon-ok" style="font-size: 200%"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  id="boks_temp_rom_bak">
                    <div class="row">
                        <div class="col-xs-6" >
                            <div class="center_tekst">
                                Temperatur i lasterom
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="center_glyphicon">
                                <span class="glyphicon glyphicon-ok" style="font-size: 200%"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  id="boks_temp_lugar">
                    <div class="row">
                        <div class="col-xs-6" >
                            <div class="center_tekst">
                                Temperatur i lugar
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="center_glyphicon">
                                <span class="glyphicon glyphicon-ok" style="font-size: 200%"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div  id="boks_vann">
                    <div class="row">
                        <div class="col-xs-6" >
                            <div class="center_tekst">
                                Vannstand
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="center_glyphicon">
                                <span class="glyphicon glyphicon-ok" style="font-size: 200%"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--
<div class="container text-center">
    <h3>What We Do</h3><br>
    <div class="row">
        <div class="col-sm-4">
            <img src="http://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
            <p>Current Project</p>
        </div>
        <div class="col-sm-4">
            <img src="http://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
            <p>Project 2</p>
        </div>
        <div class="col-sm-4">
            <div class="well">
                <p>Some text..</p>
            </div>
            <div class="well">
                <p>Some text..</p>
            </div>
        </div>
    </div>
</div><br>
-->

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
