<?php
include "../class/page.class.php";
try {
    $pdo=new PDO("mysql:host=localhost;dbname=phptest1","root","root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
}catch(PDOException $e){
    echo '数据库连接失败'.$e->getMessage();
}
//-------------------------------------------------------------------
$result=$pdo->query("select * from t3");
$rows=$result->fetchAll();
$total=count($rows);
$page= new Page($total, $listRows=10, $query="", $ord=true);
$sql="select * from t3 {$page->limit}";
$result=$pdo->query($sql);

foreach($result->fetchAll(PDO::FETCH_ASSOC)  as $value ){
    echo $value["bname"]."</br>";
}
echo $page->fpage();