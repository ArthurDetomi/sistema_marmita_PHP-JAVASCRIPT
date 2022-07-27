<?php
use \Sistema\PageAdmin;
use \Sistema\Model\User;
use \Sistema\Model\Category;
use \Sistema\Model\Product;

$app->get("/admin/categories/create",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("categories-create");
});

$app->post("/admin/categories/create",function(){
    User::verifyLogin();
    $category = new Category();
    $category->setData($_POST);
    $category->saveCategory();
    header("Location: /sistemamarmita/admin/categories");
    exit;
});

$app->get("/admin/categories",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $listCategories = Category::listAllCategories();
    $page->setTpl("categories",array(
        "categories"=>$listCategories
    ));
});

$app->post("/admin/categories/:idcategory",function($idcategory){//update
    User::verifyLogin();
    $category = new Category();
    $category->chargeCategory((int)$idcategory);
    $category->setData($_POST);
    $category->saveCategory();
    header("Location: /sistemamarmita/admin/categories");
    exit;
});

$app->get("/admin/categories/:idcategory",function($idcategory){//update
    User::verifyLogin();
    $page = new PageAdmin();
    $category = new Category();
    $category->chargeCategory((int)$idcategory);
    $page->setTpl("categories-update",array(
        "category"=>$category->getValues()
    ));
});

$app->get("/admin/categories/:idcategory/delete",function($idcategory){
    User::verifyLogin();
    $category = new Category();
    $category->chargeCategory((int)$idcategory);
    $category->deleteCategory();
    header("Location: /sistemamarmita/admin/categories");
    exit;
});

$app->get("/admin/categories/:idcategory/products",function($idcategory){
    User::verifyLogin();
    $category = new Category();
    $category->chargeCategory((int)$idcategory);
    $page = new PageAdmin();
    $page->setTpl("categories-products",array(
        "category"=>$category->getValues(),
        "productsRelated"=>$category->getProductsInCategory(),
        "productsNotRelated"=>$category->getProductsInCategory(false)
    ));

});

$app->get("/admin/categories/:idcategory/products/:idproduct/add",function($idcategory,$idproduct){
    User::verifyLogin();
    $category = new Category();
    $category->chargeCategory((int)$idcategory);
    $product = new Product();
    $product->chargeProduct((int)$idproduct);
    $category->addProductInCategory($product);
    header("Location: /sistemamarmita/admin/categories/$idcategory/products");
    exit;
});

$app->get("/admin/categories/:idcategory/products/:idproduct/remove",function($idcategory, $idproduct){
    User::verifyLogin();
    $category = new Category();
    $category->chargeCategory((int)$idcategory);
    $product = new Product();
    $product->chargeProduct((int)$idproduct);
    $category->removeProductInCategory($product);
    header("Location: /sistemamarmita/admin/categories/$idcategory/products");
    exit;
});


?>