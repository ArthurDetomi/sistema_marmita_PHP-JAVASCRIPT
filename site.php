<?php
use \Sistema\Page;
use \Sistema\Model\Product;
use \Sistema\Model\User;

$app->get("/",function(){
    $page = new Page();
    $listProducts = new Product();
    $page->setTpl("index",array(
        "products"=>$listProducts::checkList($listProducts::listAllProducts())
    ));
});

$app->post("/",function(){
    var_dump($_POST);
    exit;
});


?>