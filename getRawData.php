<?php
include "include/connect_r.php";
include "getData.php";
set_time_limit(2); //Stopper skriptet hvis det bruker over to sekunder på å kjøre.
$last_row = 0; //id til siste rad som er hentet.
//sleep(1);   //For debugging
//echo "Starting:". "\n"; //For debugging

//sleep(1);   //For debugging
$last_row = 0;

while(1){
    $conn = connect(); //Connection til SQL-databasen
    if(!mysqli_select_db($conn,'raw')){ //Velger raw-databasen.
        echo mysqli_error($conn); //Skriver ut feilmelding dersom det ikke er mulig å koble til databasen.
    }

    $query = "SELECT id,data FROM rawData WHERE gruppe = 1 AND id > ".$last_row ;//> ".$last_row; //SQL-forespørselen, husk å endre gruppe!
    $result = mysqli_query($conn, $query); //Returnerer resultatet fra SQL-forespørselen
    if($result->num_rows > 0){ //Hvis resultatet ikke er tomt
        while($row = $result->fetch_assoc()){ //les ut linjene fra resultatet.
            $temp = $row["data"]; //temp inneholder rådataene.

            //echo "lengde: ".strlen($temp)." innhold: \n"; //Debugging


            $last_row = $row["id"]; // Oppdaterer nyeste verdi som er lagt til. (Unødvendig å spørre om id
            // mindre eller like denne ved neste SQL-forespørsel).


            //echo "er inne i getData_1"."\n";
            /*for($i = 0; $i < strlen($temp); $i++){      //Debugging
                echo ord($temp[$i]);//Debugging
            }
            echo "\n";*/
            getData_1($temp);


        }
    }
    mysqli_close($conn);    //Lukke tilkoblingen til databasen. VIKTIG!



    sleep(10); //Lar skriptet spørre som de har kommet nyere data i rawData annethvert sekund.
}
?>