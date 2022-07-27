<?php
use \Sistema\Model\User;
use \Sistema\PageAdmin;
use \Sistema\Model\Product;

$app->post("/admin/products/create",function(){
    User::verifyLogin();
    $product = new Product();
    $product->setData($_POST);
    $product->saveProduct();
    header("Location: /sistemamarmita/admin/products");
    exit;
});

$app->get("/admin/products/create",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("products-create");
});

$app->get("/admin/products",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $listProducts = Product::listAllProducts();
    $page->setTpl("products",array(
        "products"=>$listProducts
    ));
});

$app->get("/admin/products/:idproduct/delete",function($idproduct){
    User::verifyLogin();
    $product = new Product();
    $product->chargeProduct((int)$idproduct);
    $product->deleteProduct();
    header("Location: /sistemamarmita/admin/products");
    exit;
});

$app->post("/admin/products/:idproduct",function($idproduct){
    User::verifyLogin();
    $product = new Product();
    $product->chargeProduct((int)$idproduct);
    $product->setData($_POST);
    $product->saveProduct();
    $product->setPhotoProduct($_FILES["file"]);
    header("Location: /sistemamarmita/admin/products");
    exit;
});

$app->get("/admin/products/:idproduct",function($idproduct){
    User::verifyLogin();
    $product = new Product();
    $product->chargeProduct((int)$idproduct);
    $page = new PageAdmin();
    $page->setTpl("products-update",array(
        "product"=>$product->getValues()
    ));
});




?>