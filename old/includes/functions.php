
<?php

function addedToday($time){
    $day = substr($time, 8, 2);
    $month = substr($time, 5, 2);
    $year = substr($time, 0, 4);
    $cur_day = date('d');
    $cur_month = date('m');
    $cur_year = date('Y');

    return(	($day == $cur_day) &&
        ($month == $cur_month) &&
        ($year == $cur_year));
}



?>