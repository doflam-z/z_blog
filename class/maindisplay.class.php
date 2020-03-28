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

    //显示搜索的内容方法
    function search()
    {
        $str=$_GET["search_str"];
        $sql="select article_title from article where article_title like '%$str%'";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);

        $result_str=$result->fetch();
        if ( $result_str) {
        echo '<div class="box_content"><h3 class="font01">包含关键字['.$str.']的搜索结果如下</h3></div></br>';
        foreach ($result as $value) {
        echo '<div class="box_content"><h3 class="font01">' . $value["article_title"] . '</h3></div></br>';
        }
        echo '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
        }else{
        echo '<div class="box_content"><h3 class="font01">关键字['.$str.']无搜索结果</h3></div></br>';
        }
    }

    //显示默认分页的内容方法
    function fpage()
    {
        $sql="select * from article";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            echo '<div class="box_content"><h3 class="font01">' . $value["article_title"] . '</h3></div></br>';
        }
        echo '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
    }

    //输出分类导航标签方法
    function cateNav(){
        $pdo=$this->mysqlCont();
        $sql = "select * from category";
        $result = $pdo->query($sql);
        $rows=$result->fetchAll();
        return $rows;
    }

    //显示分类的内容方法
    function category()
    {
        $cate_name=$_GET["nav"];
        $sql="select * from article where cate_name='".$cate_name."'";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);

        echo '<div class="box_content"><h3 class="font01">【' . $cate_name . '】分类的文章如下</h3></div></br>';
        foreach ($result as $value) {
            echo '<div class="box_content"><h3 class="font01">' . $value["article_title"] . '</h3></div></br>';
        }
        echo '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
    }

    //显示后台文章管理的方法
    function article_manage()
    {
        $tablename="article";
        $sql="select * from $tablename";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);
        $main_display=null;
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a href='?menu=article'>全部文章</a></li><li><a href='?menu=article_draft'>草稿箱</a></li></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $main_display.= "<div class='box_content'><h3 class='font01'> <a href='/markdown.php?article_id=$id&tablename=$tablename'> {$value["article_title"]}</a>=>$id</h3><div class='manage_button'><a href='?menu=article_display&articleid=$id&tablename=$tablename'>查看</a> | <a href='?num={$page->pageNum()}&de_id=$id&de_tablename=$tablename' style='color: #e9322d'>删除</a></div></div></br>";
        }
        $main_display.= '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
        return $main_display;
    }
    //显示草稿箱的方法
    function article_draft()
    {
        $tablename="draft";
        $sql="select * from $tablename";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);
        $main_display=null;
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li><a href='?menu=article'>全部文章</a></li><li style='border-bottom: 2px solid #2f96b4'><a href='?menu=article_draft'>草稿箱</a></li></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $main_display.= "<div class='box_content'><h3 class='font01'> <a href='/markdown.php?article_id=$id&tablename=$tablename'> {$value["article_title"]}</a> --{$value["cate_name"]}--$id </h3><div class='manage_button'><a href='?menu=article_display&articleid=$id&tablename=$tablename'>查看</a> | <a href='?menu=article_draft&num={$page->pageNum()}&de_id=$id&de_tablename=$tablename' style='color: #e9322d'>删除</a></div></div></br>";
        }
        $main_display.= '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
        return $main_display;
    }

    //显示后台分类管理的方法
    function cate_manage()
    {
        $tablename="category";
        $sql="select * from $tablename";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);
        $main_display=null;
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a href='?menu=cate'>全部分类</a></li><li style='border-bottom: 2px solid #2f96b4 '><form action='' method='post'><button type='submit'>新增分类</button></form></li></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $main_display.= "<div class='box_content'><h3 class='font01'> {$value["cate_name"]}=>{$value["id"]}</h3><div class='manage_button'><a href='?menu=cate&up_id=$id&up_tablename=$tablename&num={$page->pageNum()}' style='color: #149bdf'>编辑</a> | <a href='?&menu=cate&de_id=$id&de_tablename=$tablename&num={$page->pageNum()}' style='color: #e9322d'>删除</a></div></div></br>";
        }
        $main_display.= '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
        return $main_display;
    }
    //显示评论管理的方法
    function comment_manage()
    {
        $tablename="comment";
        $sql="select * from $tablename";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);
        $main_display=null;
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a href='?menu=article'>全部评论</a></li></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $main_display.= "<div class='box_content'><h3 class='font01'> {$value["comment_content"]}</h3><div class='manage_button'><a href='?menu=comment&up_id=$id&up_tablename=$tablename&num={$page->pageNum()}' style='color: #149bdf'>编辑</a> | <a href='?menu=comment&de_id=$id&de_tablename=$tablename&num={$page->pageNum()}' style='color: #e9322d'>删除</a></div></div></br>";
        }
        $main_display.= '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
        return $main_display;
    }

    //显示文章内容的方法
    function article_display()
    {
        include "class/HyperDown/Parser.php";
        $parser = new HyperDown\Parser;
        $html = $parser->makeHtml($str);
        echo "<div class=\"markdown-body editormd-preview-container\"><?php echo $html?></div>";
    }

    //新增分类的方法
    function newcate(){

    }
    //查看新增文章的方法
    function newArticle(){
        if ($_GET["up_id"]){
            $pdo=$this->mysqlCont();
//            $sql="select * from {$_GET["up_tablename"]} where id={$_GET["up_id"]}";
            $sql="select * from article where id='26'";
            $result=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $result["0"]["article_title"];
            $result["0"]["article_content"];
        }
    }

    //删除文章的方法
    function article_delete(){
        if ($_GET["de_id"]){
            $sql='delete from'.' '.$_GET["de_tablename"].' '.'where id='.$_GET["de_id"];
            echo $sql;
            $pdo=$this->mysqlCont();
            $result = $pdo->exec($sql);
            if ($result>0){
                header("Location:/admin/index.php?menu={$_GET["menu"]}&page={$_GET["num"]}");
//                echo "<script>alert('删除成功')</script>";
            }else{
                echo "<script>alert('删除失败')</script>";
            }
        }
    }
}
/*$a=new MainDisplay();
echo $a->newArticle();*/

