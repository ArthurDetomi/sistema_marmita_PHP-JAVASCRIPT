<?php
use \Sistema\Page;
use \Sistema\Model\Product;
use \Sistema\Model\User;
use \Sistema\Model\Purchase;


$app->post("/",function(){
    
    if(isset($_POST["value-total-perso"])){

        $purchase = new Purchase();
        $purchase->getListProducts($_POST["json"], true); //passa mas com true, quer dizer que foi defino um valor personalizado de venda
        $purchase->setPaymentMethod($_POST["payment"]);
        $purchase->setValuePerso($_POST["value-total-perso"]);
        $purchase->registerSale(); //registra a venda

    }else if(isset($_POST["json"]) == TRUE && isset($_POST["payment"]) == TRUE){

        $purchase = new Purchase();
        $purchase->getListProducts($_POST["json"]);
        $purchase->setPaymentMethod($_POST["payment"]);
        $purchase->registerSale(); //registra a venda

    }
    
    header("Location: /sistemamarmita/");
    exit;

});

$app->get("/",function(){
    $page = new Page();
    $listProducts = new Product();
    $page->setTpl("index",array(
        "products"=>$listProducts::checkList($listProducts::listAllProducts())
    ));
});
/*
$app->get("/:idproduct/:quantity/plus",function($idproduct, $quantity){
    setListPurchase($idproduct, $quantity);
    header("Location: /sistemamarmita/");
    exit;
});

$app->get("/:idproduct/minus",function($idproduct){
    setListPurchase($idproduct, $quantity);
    header("Location: /sistemamarmita/");
    exit;
});
*/

?>