<?php
use \Sistema\Page;

$app->get("/",function(){
    $page = new Page();
    $page->setTpl("index");
});

?>