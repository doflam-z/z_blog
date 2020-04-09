<?php
//文章存取类
class ArticleAccess{
    //连接数据库
    function mysqlCont(){
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
        } catch (PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
        }
        return $pdo;
    }
    //保存方法
    function articleSave(){
        if (isset($_POST["publish"])){
            $tablename="article";
        }else{
            $tablename="draft";
        }
        $pdo=$this->mysqlCont();
        $time=time();
        $article_content=$_POST["mark"];
        $article_content=$this->articleChang($article_content);
        $query="insert into $tablename (article_title,article_content,cate_name,article_time) value('{$_POST["article_title"]}','$article_content','{$_POST["category"]}','$time')";
//        $result=$pdo->exec($query);
        try {
            $result=$pdo->exec($query);
        } catch (PDOException $e) {
            echo "SQL语句执行错误:{$e->getMessage()}</br>";
        }
        if($result>0){
            echo "执行成功";
        }else{
            echo "执行失败";
        }
    }
    //修改文章方法
    function articleEdit($id){
        if (isset($_POST["edit"])){
            $tablename="article";
        }/*else{
            $tablename="draft";
        }*/
        $pdo=$this->mysqlCont();
        $time=time();
        $article_content=$_POST["mark"];
        $article_content=$this->articleChang($article_content);
//        $query="update $tablename(article_title,article_content,cate_name,article_time) value('{$_POST["article_title"]}','$article_content','{$_POST["category"]}','$time') where id='$id'";
        $query="update $tablename set article_title='{$_POST["article_title"]}',article_content='$article_content',cate_name='{$_POST["category"]}',article_time='$time' where id='$id'";
        try {
            $result=$pdo->exec($query);
        } catch (PDOException $e) {
            echo "SQL语句执行错误:{$e->getMessage()}</br>";
        }
        if($result>0){
            echo "<div style='margin:200px auto;width: 500px;height:300px;color: #e9322d;text-align: center;'>修改成功！</br></br><a href='../admin/index.php' style='text-decoration: none;color: #00a8c6;font-size: 18px'>返回文章管理</a></div>";
        }else{
            echo "执行失败";
        }
    }

    //查看文章方法
    function articleDisplay(){
        include "HyperDown/Parser.php";
        $parser = new HyperDown\Parser;
        $pdo=$this->mysqlCont();
        $sql="select * from {$_GET["tablename"]} where id='{$_GET["articleid"]}'";
        $article_id=$_GET["articleid"];
        $this->readNum($article_id);
        $result=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $str=$result[0]["article_content"];
        $title=$result[0]["article_title"];
        $html = $parser->makeHtml($str);
        $comment_content=$this->read_comment($article_id);
        $result='';
        $result.= "<div class='markdown-body editormd-preview-container'><h2>$title</h2><?php echo $html?></div>";
        $result.= "<div class='comment'>$comment_content</div>";
        $result.= "<div class='comment'><form action='' method='post'><textarea name='comment_content'></textarea><button class='button' type='submit' name='sbubmit_comment' value='$article_id'>发表评论</button></form></div>";
        return $result;
    }
    //读取markdown源码
    function take($id,$tablename){
        $pdo=$this->mysqlCont();
        $sql="select * from $tablename where id='$id'";
        $result=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $article_id=$result[0]["article_title"];
        $article_content=$result[0]["article_content"];
        $result=array("title"=>$article_id,"content"=>$article_content);
        return $result;
    }
    //查询分类
    function category(){
        $pdo=$this->mysqlCont();
        $sql="select cate_name from category;";
        $rows=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $result='';
        foreach($rows as $values){
            $result.= "<option  value='{$values["cate_name"]}'>{$values["cate_name"]}</option>";
        }
        return $result;
    }

    function articleChang($article_content)
    {
        $patterns="/\'/";
        $keywords="\'";
        return $str=preg_replace($patterns,$keywords,$article_content);
    }
    //增加文章阅读数
    function readNum($article_id){
        $sql="update article set article_views=article_views+1 where id='$article_id'";
        $pdo=$this->mysqlCont();
        $pdo->exec($sql);
    }

    //保存评论方法
    function comment(){
        $tablename="comment";
        $pdo=$this->mysqlCont();
        $time=time();
        $comment_content=$_POST["comment_content"];
        $comment_content=$this->articleChang($comment_content);
        $query="insert into $tablename (comment_content,comment_time,username,article_id) value('$comment_content','$time','{$_SESSION["user_name"]}','{$_POST["sbubmit_comment"]}')";
        try {
            $result=$pdo->exec($query);
        } catch (PDOException $e) {
            echo "SQL语句执行错误:{$e->getMessage()}</br>";
        }
        if($result>0){
            header("Location:");
        }else{
            echo "执行失败";
        }
    }
    //显示最新评论方法
    function read_comment($article_id){
        $tablename="comment";
        $pdo=$this->mysqlCont();
        $sql="select * from $tablename where article_id='$article_id'";
        try {
            $result=$pdo->query($sql);
        } catch (PDOException $e) {
            echo "SQL语句执行错误:{$e->getMessage()}</br>";
        }
        $main_display='';
        $main_display.= "<div class='comment_content'><h3>最新评论</h3></div>";
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
            $comment=$value["comment_content"];
            $user_name=$value["username"];
            $time=date('Y年m月d日 H:i:s',$value["comment_time"]);
            $main_display.= "<div class='comment_content'><h3><b style='font-size: 20px;color: #7ab5d3'>$user_name</b> : <span style='color: #6E6E68'>$comment</span></h3></div><div class='span'
<span class='time'>$time</span></div></br>";
        }
        return $main_display;
    }
}
/*$a=new ArticleAccess();
$str="a'b'c'd'";
echo $a->articleChang($str);*/