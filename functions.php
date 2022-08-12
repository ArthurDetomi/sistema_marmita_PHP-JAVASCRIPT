<?php

function formatDescription($description)
{
    
    return str_replace("-","<br>", $description);
    
}

function formatPrice($price)
{
    $aux = (string)$price;
    return str_replace(".",",",$aux);
}

function formatDate($date)
{
    $date = str_replace(" ","<br>", $date);
    $sub =  substr($date, 0,strpos($date, "<br>"));
    $time =  substr($date,strpos($date, "<br>"),strlen($date) - 1);
    return date("d/m/Y", strtotime($sub)).$time;
}



?>