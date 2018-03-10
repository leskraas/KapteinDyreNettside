<?php
/**
 * Created by PhpStorm.
 * User: larserikskraastad
 * Date: 02.02.2016
 * Time: 16.24
 */

include("../login_includes/db_connect.php");
include ("../login_includes/functions.php");

sec_session_start();

?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset = "utf-8"/>
    <title> Kaptein Dyre</title>


    <?php
    include("includes/includer.php");
    //$conn = connect();
    ?>



</head>

<?php if(login_check($mysqli) == "gruppe1") :/* VIKTIG! Alt som kommer etter denne kodelinja må man være innlogget for å  se*/ ?>

<body>

<?php
include "header.php";
?>






<div class="baat_map" style="width: 100%; position: relative">
    <img src="../Bilder/Batvakt3d.png">
    <div id="temp_lugar" style="width: 20%; position: absolute; float: right; z-index: 2; top: 45%; right: 15%" >
        <img src="../Bilder/Batvakt2.png">
    </div>
    <div id="temp_motor_oppe" style="width: 20%; position: absolute; float: right; z-index: 2; top: 45%; right: 30%" >

    </div>

</div>


<?php
include "graph/graf_temp_map.php"
?>



<?php
include "includes/section_graf.php"
?>






    <?php
    //Inkluderer footer
    include("includes/footer.php");

    //Lukker tilkoblingen til databasen.
    //$conn->close();
    ?>


<?php else : /*Dette vises hvis en bruker forsøker å få tilgang til siden uten å være innlogget*/?>
    Du er ikke innlogget.
<?php endif; ?>


</body>

</html>

