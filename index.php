<?php
session_start(); //iniciando o uso de sessões
require_once("vendor/autoload.php");
use \Slim\Slim;
use \Sistema\Page;
use \Sistema\PageAdmin;
use \Sistema\Model\User;

$app = new Slim();
$app->config("debug", true);

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