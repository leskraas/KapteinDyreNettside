<?php
/**
 * Created by PhpStorm.
 * User: larserikskraastad
 * Date: 08.03.2016
 * Time: 09.01
 */
?>


<section>
    <h1 style="font-weight: 300"> Vann</h1>
    <div style="width:100%;height:100px;background-color: #00b2ee; opacity: 0.8;">
        <a href="vann.php"><span class="snittverdi"><?php include "graph/siste_verdi_vannstand.php";?></span></a>
        <!--<div id="curve_chart_vann" style="width: 70%; height: 100%"></div>-->
        <?php include "graph/graf_vann_liten.php" ?>
    </div>
</section>
<section>
    <h1 style="font-weight: 300"> Temperatur</h1>
    <div style="width:100%;height:100px;background-color: #32cd32;opacity: 0.8;">
        <a href="temp.php"><span class="snittverdi"><?php include "graph/siste_verdi_snitt_temp.php";?></span></a>
        <!--<div id="curve_chart_temp" style="width: 70%; height: 100%"></div>-->
        <?php include "graph/graf_temp_snitt_liten.php" ?>
</section>
<section>
    <h1 style="font-weight: 300"> Brann/Innbrudd</h1>
    <div style="width:100%;height:100px;background-color: #eb9316;opacity: 0.8;">
        <a href="#"> <span class="glyphicon glyphicon-ok" style="margin-top: 0px"></span> </a>
</section>


<section>
    <img src="http://www.w3newbie.com/wp-content/uploads/trainers.png"/>
    <h1>Hvem er vi!</h1>
    <p>Vi er 5 studenter som har designet en båtvakt. Den er lekajfmlnfløme ljdsjkl s l sdkf jslfkds sflsfsdlkds ødløkfj slfkejls</p>
</section>
<section>
    <img src="http://www.w3newbie.com/wp-content/uploads/location.png"/>
    <h1>Hvor finner du oss?</h1>
    <p>Vi har lokaler ved NTNU</p>
</section>
<section>
    <img src="http://www.w3newbie.com/wp-content/uploads/check.png"/>
    <h1>Noe mer morsomt?</h1>
    <p>Det kommer an på hva vi skriver her da!</p>
</section>

