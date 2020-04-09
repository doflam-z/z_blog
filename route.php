<?php
//定义路由
    session_start();
    $uri = $_SERVER['REQUEST_URI'];
    switch($uri){
        case "/":  include "home/index.php";  break;
        case "/login":  include "models/login.php";  break;
        case "/admin":  include "admin/index.php";  break;
    }

