<?php
if(isset($_POST["search"])) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
    } catch (PDOException $e) {
        echo '数据库连接失败' . $e->getMessage();
    }

    $str=$_POST["search_str"];
    $sql="select bname from t3 where bname like '%'.$str.'%'";
    $result=$pdo->query($sql);
    $rows=$result->fetchAll(PDO::FETCH_ASSOC);
    if ($rows !== array('')) {
        echo '<div class="box_content"><h3 class="font01">关于'.$str.'的搜索结果如下</h3></div></br>';
        foreach ($rows as $value) {
            echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
        }
    }
}