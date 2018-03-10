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







<?php
include "includes/section_graf.php"
?>






<?php
//Inkluderer footer
include("includes/footer.php");

?>


<?php else : /*Dette vises hvis en bruker forsøker å få tilgang til siden uten å være innlogget*/?>
    Du er ikke innlogget.
<?php endif; ?>


</body>

</html>

