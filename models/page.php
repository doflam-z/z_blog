<?php
include "class/page.class.php";
try {
    $pdo=new PDO("mysql:host=localhost;dbname=phptest1","root","root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
}catch(PDOException $e){
    echo '数据库连接失败'.$e->getMessage();
}
//-------------------------------------------------------------------
$result=$pdo->query("select * from t3");
$rows=$result->fetchAll();

//------------------------------------------------------------------------
$sql="select bname from t3 where btype='chengxu' ";
$result=$pdo->query($sql);
$rows=$result->fetchAll(PDO::FETCH_ASSOC);
switch ($_GET["nav"]){
    case "net":
        echo '<div class="box_content"><h3 class="font01">属于[网络]分类的文章如下</h3></div></br>';
        foreach ($rows as $value3) {
            echo '<div class="box_content"><h3 class="font01">' . $value3["bname"] . '</h3></div></br>';
        }
        break;
}



//------------------------------------------------------------------------

if(isset($_POST["search"])){
    $str=$_POST["search_str"];
    $sql="select bname from t3 where bname like '%$str%'";
    $result=$pdo->query($sql);
    $rows=$result->fetchAll(PDO::FETCH_ASSOC);
    if ($rows !== array()) {
        echo '<div class="box_content"><h3 class="font01">包含关键字['.$str.']的搜索结果如下</h3></div></br>';
        foreach ($rows as $value) {
            echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
        }
    }else{
        echo '<div class="box_content"><h3 class="font01">关键字['.$str.']无搜索结果</h3></div></br>';
    }
}else{
    $total = count($rows);
    $page = new Page($total, $listRows = 6, $query = "", $ord = true);
    $sql = "select * from t3 {$page->limit}";
    $result = $pdo->query($sql);

    foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
        echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
    }
    echo $page->fpage();
}