<?php
//连接数据库
try {
    $pdo=new PDO("mysql:host=localhost;dbname=z_blog","root","root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
}catch(PDOException $e){
    echo '数据库连接失败'.$e->getMessage();
}