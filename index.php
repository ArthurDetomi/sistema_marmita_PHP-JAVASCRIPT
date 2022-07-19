<?php
session_start(); //iniciando o uso de sessões
require_once("vendor/autoload.php");
use \Slim\Slim;
use \Sistema\Page;
use \Sistema\PageAdmin;
use \Sistema\Model\User;

$app = new Slim();
$app->config("debug", true);

$app->get("/admin/users/:iduser/delete",function($iduser){ //delete
    User::verifyLogin();
    $user = new User();
    $user->chargeUser((int)$iduser);
    $user->deleteUser();
    header("Location: /sistemamarmita/admin/users");
    exit;
});

$app->post("/admin/users/create",function(){ //create
    User::verifyLogin();
    $user = new User();
    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
    //$_POST["despassword"] = User::getHashPassword($_POST["despassword"]);
    $user->setData($_POST);
    $user->saveData();
    header("Location: /sistemamarmita/admin/users");
    exit;
});

$app->get("/admin/users/create",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->post("/admin/users/:iduser",function($iduser){ //update
    User::verifyLogin();
    $user = new User();
    $user->chargeUser((int)$iduser);
    $user->setData($_POST);
    $user->updateUser();
    header("Location: /sistemamarmita/admin/users");
    exit;
});

$app->get("/admin/users/:iduser",function($iduser){ //update
    User::verifyLogin();
    $page = new PageAdmin();
    $user = new User();
    $user->chargeUser((int)$iduser);
    $page->setTpl("users-update",array(
        "user"=>$user->getValues()
    ));
});

$app->get("/admin/forgot",function(){
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl("forgot");
});

$app->get("/admin/users",function(){
    User::verifyLogin();
    $users = User::listAllUsers();
    $page = new PageAdmin();
    $page->setTpl("users",array(
        "listUsers"=>$users
    ));
});

$app->post("/admin/login",function(){
    User::login($_POST["login"], $_POST["password"]);
    header("Location: /sistemamarmita/admin");
    exit;
});

$app->get("/admin/login",function(){
    $page = new PageAdmin(array(
        "header"=>false,
        "footer"=>false
    ));
    $page->setTpl("login");
});

$app->get("/admin/logout",function(){
    User::logout();
    header("Location: /sistemamarmita/admin/login");
    exit;
});

$app->get("/admin",function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");
});

$app->get("/",function(){
    $page = new Page();
    $page->setTpl("index");
});

$app->run();
?>