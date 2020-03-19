<?php
//定义路由
    $uri = $_SERVER['REQUEST_URI']; 
    switch($uri){
        case "/":  include "home/index.php";  break;
        case "/login":  include "home/login.php";  break;
        case "/code":  include "models/code.php";  break;
    }

