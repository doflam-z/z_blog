<?php
include "../class/page.class.php";
try {
    $pdo=new PDO("mysql:host=localhost;dbname=phptest1","root","root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
}catch(PDOException $e){
    echo '数据库连接失败'.$e->getMessage();
}
//-------------------------------------------------------------------

$sql="select * from t3 where btype='chengxu' ";
$row=$pdo->query($sql)->fetch();
$cate_name=$row["btype"];
$rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

switch ($_GET["nav"]){
    case "net":
        echo '<div class="box_content"><h3 class="font01">属于['.$cate_name.']分类的文章如下</h3></div></br>';
        foreach ($rows as $value) {
            echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
        }
        break;
}

//------------------------------------------------------------------------


