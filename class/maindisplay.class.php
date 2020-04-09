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
        $tablename="article";
        $str=trim($_GET["search_content"]);
        $sql="select * from article where article_title like '%$str%'";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $rows = $pdo->query($sql);
        $rows_str=$rows->fetch();
        $result="";
        if ( $rows_str) {
            $result.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a style='color: #0e0e0e' href='?menu=article'><b>标题包含关键字[$str]的文章如下</b></a></li></ul></div>";
        foreach ($rows as $value) {
            $id=$value["id"];
            $views=$value["article_views"];
            $comment=$value["comment_num"];
            $time=date('Y年m月d日 H:i:s',$value["article_time"]);
            $result.= "<div class='box_content'><h3><a href='?menu=article_display&articleid=$id&tablename=$tablename'> {$value["article_title"]}</a></h3><div class='span'
<span class='time'>$time</span> <span class='read'>&nbsp;&nbsp;&nbsp;<img src='../public/image/图标/1158849.png'>&nbsp;$views</span>&nbsp;&nbsp;<span class='comment'><img src='../public/image/图标/1222902.png'>&nbsp;$comment</span></div><div class='manage_button'></div></div></br>";
        }
            $result.= '<div class="box_content_list" style="height: 50px">' .$page->fpage(5,6). '</div>';
        }else{
            $result.= '<div class="box_content"><h3 class="font01">关键字['.$str.']无搜索结果</h3></div></br>';
        }
        return $result;
    }

    //显示默认全部文章分页的内容方法
    function fpage()
    {
        $tablename="article";
        $sql="select * from $tablename";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $usersection=new UserSection();
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $result = $pdo->query($sql);
        $main_display=null;
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a style='color: #0e0e0e' href='?menu=article'><b>全部文章</b></a></li></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $views=$value["article_views"];
            $comment=$usersection->comment_num($id);
            $time=date('Y年m月d日 H:i:s',$value["article_time"]);
            $main_display.= "<div class='box_content'><h3><a href='?menu=article_display&articleid=$id&tablename=$tablename'> {$value["article_title"]}</a></h3><div class='span'
<span class='time'>$time</span> <span class='read'>&nbsp;&nbsp;&nbsp;<img src='../public/image/图标/1158849.png'>&nbsp;$views</span>&nbsp;&nbsp;<span class='comment'><img src='../public/image/图标/1222902.png'>&nbsp;$comment</span></div><div class='manage_button'></div></div></br>";
        }
        $main_display.= '<div class="box_content_list" style="height: 30px">' .$page->fpage(5,6). '</div>';
        return $main_display;
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
        $tablename="article";
        $cate_name=$_GET["nav"];
        $sql="select * from article where cate_name='".$cate_name."'";
        $pdo=$this->mysqlCont();
        $rows=$pdo->query($sql)->fetchAll();
        //-------使用分页类部分
        $total = count($rows);
        $page = new Page($total, $listRows = 6, $query = "", $ord = true);
        $sql = $sql.' '.$page->limit;
        $rows = $pdo->query($sql);
        $result="";
        $result.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a style='color: #0e0e0e' href='?menu=article'><b>【 $cate_name 】分类的文章如下</b></a></li></ul></div>";
        foreach ($rows->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $views=$value["article_views"];
            $comment=$value["comment_num"];
            $time=date('Y年m月d日 H:i:s',$value["article_time"]);
            $result.= "<div class='box_content'><h3><a href='?menu=article_display&articleid=$id&tablename=$tablename'> {$value["article_title"]}</a></h3><div class='span'
<span class='time'>$time</span> <span class='read'>&nbsp;&nbsp;&nbsp;<img src='../public/image/图标/1158849.png'>&nbsp;$views</span>&nbsp;&nbsp;<span class='comment'><img src='../public/image/图标/1222902.png'>&nbsp;$comment</span></div><div class='manage_button'></div></div></br>";
        }
        $result.= '<div class="box_content_list" style="height: 30px">' .$page->fpage(5,6). '</div>';
        return $result;
    }
    //显示全部评论的方法
    function comment(){
        $pdo=$this->mysqlCont();
        $sql = "select * from comment";
        $rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $result="";
        $result.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a style='color: #0e0e0e'><b>全部评论</b></a></li></ul></div>";
        foreach ($rows as $value) {
            $comment=$value["comment_content"];
            $user_name=$value["username"];
            $time=date('Y年m月d日 H:i:s',$value["comment_time"]);
            $result.= "<div class='comment_content'><h3><b style='font-size: 26px;color: #7ab5d3'>$user_name</b> : <span style='color: #6E6E68'>$comment</span></h3></div><div class='span'
<span class='time'>$time</span></div></br>";
        }
        return $result;
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
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a style='color: #0e0e0e' href='?menu=article'><b>全部文章</b></a></li><li><a href='?menu=article_draft'>草稿箱</a></li></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $views=$value["article_views"];
            $comment=$value["comment_num"];
            $time=date('Y年m月d日 H:i:s',$value["article_time"]);
            $main_display.= "<div class='box_content'><h3><a href='/models/markdown.php?article_id=$id&tablename=$tablename'> {$value["article_title"]}</a></h3><div class='span'
<span class='time'>$time</span> <span class='read'>&nbsp;&nbsp;&nbsp;<img src='../public/image/图标/1158849.png'>&nbsp;$views</span>&nbsp;&nbsp;<span class='comment'><img src='../public/image/图标/1222902.png'>&nbsp;$comment</span></div><div class='manage_button'><a href='?menu=article_display&articleid=$id&tablename=$tablename'>查看</a> | <a href='?num={$page->pageNum()}&de_id=$id&de_tablename=$tablename' style='color: #e9322d'>删除</a></div></div></br>";
        }
        $main_display.= '<div class="box_content_list" style="height: 30px">' .$page->fpage(5,6). '</div>';
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
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li><a href='?menu=article'>全部文章</a></li><li style='border-bottom: 2px solid #2f96b4'><a style='color: #0e0e0e' href='?menu=article_draft'><b>草稿箱</b></a></li></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $time=date('Y年m月d日 H:i:s',$value["article_time"]);
            $main_display.= "<div class='box_content'><h3 class='font01'> <a href='/markdown.php?article_id=$id&tablename=$tablename'> {$value["article_title"]}</a> </h3><div class='span'
<span class='time'>$time</span> <span class='read'>&nbsp;&nbsp;&nbsp;<img src='../public/image/图标/1158849.png'>&nbsp;1</span>&nbsp;&nbsp;<span class='comment'><img src='../public/image/图标/1222902.png'>&nbsp;0</span></div><div class='manage_button'><a href='?menu=article_display&articleid=$id&tablename=$tablename'>查看</a> | <a href='?menu=article_draft&num={$page->pageNum()}&de_id=$id&de_tablename=$tablename' style='color: #e9322d'>删除</a></div></div></br>";
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
        $main_display.= "<div class='main-content-nav'><ul class='content-nav'><li style='border-bottom: 2px solid #2f96b4 '><a href='?menu=cate'>全部分类</a></li><form action='' method='post'><button class='button button_cate' type='submit'><a class='cateadd' href='?menu=cate_add'>新增分类</a></button></form></ul></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $id=$value["id"];
            $cate_name=$value["cate_name"];
            $main_display.= "<div class='box_content'><h3 class='font01'> {$value["cate_name"]}</h3><div class='manage_button'><a href='?menu=cate_edit&up_id=$id&up_name=$cate_name' style='color: #149bdf'>编辑</a> | <a href='?&menu=cate&de_id=$id&de_tablename=$tablename&num={$page->pageNum()}' style='color: #e9322d'>删除</a></div></div></br>";
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

    //新增、修改分类的方法
    function newcate(){
        $result='';
        if($_GET["menu"]=="cate_edit"){
            $str="修改";$upname=$_GET["up_name"];$cate="cate_edit";
            $up_id=$_GET["up_id"];
        }elseif ($_GET["menu"]=="cate_add"){
            $str="新增";$cate="cate_add";
        }
        $result.= '<a href="/admin/index.php?menu=cate" style="text-decoration: none;color: #8a8a8a;"><=返回分类管理</a><form action="/admin/index.php?menu='.$cate.'&up_id='.$up_id.'" method="post">
    <table align="center" width="300">
        <caption><h3>'.$str.'分类</h3></caption>
        <tr><td>分类名称&nbsp;&nbsp;<input style="border-radius: 6px;border: 1px solid #b1acac; height: 25px;width: 175px;" type="text" name="cate_name"value="'.$upname.'"></td></tr>
        <tr><td><button class="button button_cateadd" type="submit" name="newcate" style="position: relative;left: 5px;margin-bottom: 20px;">提交</button></td></tr>
    </table>
</form>';
        if ($_GET["menu"]=="cate_add" and isset($_POST["newcate"]) and $_POST["cate_name"]!=='') {
            $sql = "insert into category (cate_name) values('{$_POST["cate_name"]}')";
            $pdo=$this->mysqlCont();
            try {
                $num = $pdo->exec($sql);
            } catch (PDOException $e) {
                $result.= 'SQL语句执行错误：' . $e->getMessage().'</br>';
            }
            if ($num > 0) {
                header("Location:/admin/index.php?menu=cate");
            } else {
                $result.=  "执行失败";
            }
        }elseif ($_GET["menu"]=="cate_edit" and isset($_POST["newcate"]) and $_POST["cate_name"]!==''){
            $result=print_r($_POST);
            $result=print_r($_GET);
            $sql = "update category set cate_name='{$_POST["cate_name"]}' where id='{$_GET["up_id"]}'";
            $result.=$sql;
            $pdo=$this->mysqlCont();
            try {
                $num = $pdo->exec($sql);
            } catch (PDOException $e) {
                $result.= 'SQL语句执行错误：' . $e->getMessage().'</br>';
            }
            if ($num > 0) {
                header("Location:/admin/index.php?menu=cate");
            } else {
                $result.=  "执行失败";
            }
        }elseif (isset($_POST["newcate"]) and $_POST["cate_name"]==''){ $result.="分类名称不能为空！";}
/*        $result.=print_r($_GET);
        $result.=print_r($_POST);
        $result.= $sql.'1111111';*/
        return $result;
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

    //test
/*    function list(){
        $button_edit="/markdown.php?article_id=$id&tablename=$tablename";
        $button_title="{$value["article_title"]}";
        $button_view="?menu=article_display&articleid=$id&tablename=$tablename";
        $button_delete="?num={$page->pageNum()}&de_id=$id&de_tablename=$tablename";
        $button_comment="";
        $read="";
        $result='';
        $result.="<div class='box_content'><h3><a href='$edit'>$display1</a></h3><div class='span'><span class='time'>$time</span> <span class='read'>&nbsp;&nbsp;&nbsp;<img src='../public/image/图标/1158849.png'>&nbsp;$read</span>&nbsp;&nbsp;<span class='comment'><img src='../public/image/图标/1222902.png'>&nbsp;$comment</span></div><div class='manage_button'><a href='$value2'>查看</a> | <a href='$value3' style='color: #e9322d'>删除</a></div></div></br>";
        return $result;
    }*/

}
