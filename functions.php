<?php

$listPurchases = [];

function getListPurchase()
{
    return $GLOBALS["listPurchases"];
}

function setListPurchase($idproduct, $quantity)
{
    $newArray = [];
    $existe = 0;

    if(count($GLOBALS["listPurchases"]) > 0){

        for($i = 0; $i < count($GLOBALS["listPurchases"]); $i++){
                
            foreach($GLOBALS["listPurchases"][$i] as $key => $value){
                    
                if($key == $idproduct){
                    $existe = 1;
                    $value = $quantity;
                    break;
                }

                    
            }

        }

    }
    if($existe == 0){

        $newArray = [$idproduct => $quantity];   
        array_push($GLOBALS["listPurchases"], $newArray);

    }
}




?>