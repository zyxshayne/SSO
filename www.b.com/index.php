<?php
include __DIR__."\\"."Session.php";
$session  = new Session(array("HOST" => '192.168.83.132',"PORT" => '6379'));
require_once __DIR__.'\\'.'Controller.php';
$obj = new Controller();
$query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
$query = explode('=',$query);
$path =parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$path = explode('/',$path);

if($path[2]=='index'){
    $obj->index();
}elseif($path[2] =="success"){
    $obj->success();
}





