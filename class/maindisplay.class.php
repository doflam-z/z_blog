<?php
/**
* Class MainDisplay控制主页面显示内容类
*/
class MainDisplay
{
    private $dbname;    //需要查询的数据库名称

    function __construct($dbname="phptest1")
    {
    $this->dbname=$dbname;
    }

    //显示搜索的内容方法
    function search()
    {
    $pdo=$this->mysqlCont();
    $str=$_GET["search_str"];
    $sql="select bname from t3 where bname like '%$str%'";
    $result=$pdo->query($sql);
    $rows=$result->fetchAll();
    $total = count($rows);
    $page = new Page($total, $listRows = 6, $query = "", $ord = true);
    $sql = "select bname from t3 where bname like '%$str%' {$page->limit}";
    $result = $pdo->query($sql);
    if ($result !== array()) {
    echo '<div class="box_content"><h3 class="font01">包含关键字['.$str.']的搜索结果如下</h3></div></br>';
    foreach ($result as $value) {
    echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
    }
    echo $page->fpage();
    }else{
    echo '<div class="box_content"><h3 class="font01">关键字['.$str.']无搜索结果</h3></div></br>';
    }
    }

    //显示默认分页的内容方法
    function fpage()
    {
    $pdo=$this->mysqlCont();
    $result=$pdo->query("select * from t3");
    $rows=$result->fetchAll();
    $total = count($rows);
    $page = new Page($total, $listRows = 6, $query = "", $ord = true);
    $sql = "select * from t3 {$page->limit}";
    $result = $pdo->query($sql);

    foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
    echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
    }
    echo $page->fpage();
    }


    //显示分类的内容方法
    function category()
    {
        $pdo=$this->mysqlCont();
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
    }

    //连接数据库方法
    function mysqlCont()
    {
    try {
    $pdo = new PDO("mysql:host=localhost;dbname=$this->dbname", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
    } catch (PDOException $e) {
    echo '数据库连接失败' . $e->getMessage();
    }
    return $pdo;
    }
}