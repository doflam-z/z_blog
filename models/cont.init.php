<?php
//开启session
session_start();
if ((!$_SESSION['isLogin']) && ($_SERVER["PHP_SELF"] !== "/z_blog/login.php")){
    header('Location:../login.php');
}

