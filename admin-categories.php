<?php
use \Sistema\PageAdmin;
use \Sistema\Model\User;
use \Sistema\Model\Category;

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

$app->post("/admin/categories/create",function(){
    User::verifyLogin();
    $category = new Category();
    $category->setData($_POST);
    $category->saveCategory();
    header("Location: /sistemamarmita/admin/categories");
    exit;
});

$app->get("/admin/categories/create",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("categories-create");
});

$app->get("/admin/categories",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $listCategories = Category::listAllCategories();
    $page->setTpl("categories",array(
        "categories"=>$listCategories
    ));
});


?>