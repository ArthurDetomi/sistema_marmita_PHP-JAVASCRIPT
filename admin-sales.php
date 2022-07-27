<?php
use \Sistema\Model\User;
use \Sistema\Model\Sale;
use \Sistema\PageAdmin;
use \Sistema\Model\Product;

$app->get("/admin/sales",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $listSales = Sale::listAllSales();
    $page->setTpl("sales",array(
        "listSales"=>$listSales
    ));
});

$app->get("/admin/sales/:idvenda/delete",function($idvenda){
    User::verifyLogin();
    $sale = new Sale();
    $sale->chargeSale((int)$idvenda);
    $sale->deleteSale();
    header("Location: /sistemamarmita/admin/sales");
    exit;
});

$app->post("/admin/sales/:idvenda",function($idvenda){
    User::verifyLogin();
    $sale = new Sale();
    $sale->chargeSale((int)$idvenda);
    $sale->setData($_POST);
    $sale->updateSale();
    header("Location: /sistemamarmita/admin/sales");
    exit;
});

$app->get("/admin/sales/:idvenda",function($idvenda){
    User::verifyLogin();
    $sale = new Sale();
    $sale->chargeSale((int)$idvenda);
    $page = new PageAdmin();
    $page->setTpl("sales-update",array(
        "sale"=>$sale->getValues()
    ));
});


?>