<?php
//定义路由
session_start();
$uri = $_SERVER['REQUEST_URI'];
//echo $uri;
switch($uri){
    case "/":  header("Location:home/index.php");  break;
    case "/login":  header("Location:models/login.php");  break;
    case "/admin1":  header("Location:admin/index.php");  break;
}
