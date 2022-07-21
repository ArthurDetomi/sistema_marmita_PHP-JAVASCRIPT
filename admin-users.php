<?php
use \Sistema\PageAdmin;
use \Sistema\Model\User;

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

$app->get("/admin/users",function(){
    User::verifyLogin();
    $users = User::listAllUsers();
    $page = new PageAdmin();
    $page->setTpl("users",array(
        "listUsers"=>$users
    ));
});

?>