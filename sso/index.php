<?php
include __DIR__."\\"."Session.php";
$session  = new Session(array("HOST" => '192.168.83.132',"PORT" => '6379'));
require_once __DIR__.'\\'.'Controller.php';
$obj = new Controller();
$query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
$query = explode('=',$query);
//echo "<pre>";
//var_dump($query);
//exit;
$path =parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$path = explode('/',$path);
//var_dump($path);
$obj->url = $query[1];
if($path[2]=='login'){
    $obj->login();
}elseif($path[2] =="vaild"){
    $obj->vaild($query[1]);
}elseif($path[2] =="index"){
    $obj->index();
}