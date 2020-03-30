<?php
//文章存取类
class ArticleAccess{
    //保存方法
    function articleSave(){
        $pdo=$this->mysqlCont();
        if (isset($_POST["publish"])){
            $tablename="article";
        }else{
            $tablename="draft";
        }
        $time=time();
        $article_content=$_POST["mark"];
        $article_content=$this->htmlChang($article_content);
        $query="insert into $tablename (article_title,arti1cle_content,cate_name,article_time) value('{$_POST["article_title"]}','$article_content','{$_POST["category"]}','$time')";
//        $result=$pdo->exec($query);
        try {
            $result=$pdo->exec($query);
        } catch (PDOException $e) {
            echo 'SQL语句执行错误：' . $e->getMessage().'</br>';
        }
        if($result>0){
            echo "执行成功";
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
        $result=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $str=$result[0]["article_content"];
        $title=$result[0]["article_title"];
        $html = $parser->makeHtml($str);
        $result='';
        $result.= "<div class='markdown-body editormd-preview-container'><h2>$title</h2><?php echo $html?></div>";
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

    //html文件转化方法
    function htmlChang($str)
    {
        $patterns=array();
        $patterns[0]='/\,/';
        $patterns[1]='/\;/';
        $patterns[2]='/\$/';
        $patterns[3]='/\(/';
        $patterns[4]='/\)/';
        $patterns[5]='/\`/';
        $keywords=array();
        $keywords[0]='@《@';
        $keywords[1]='@|@';
        $keywords[2]='@4@';
        $keywords[3]='@9@';
        $keywords[4]='@0@';
        $keywords[5]='@-@';
        return $str=preg_replace($patterns,$keywords,$str);
    }

//恢复html方法
    function htmlRegain($str)
    {
        $patterns=array();
        $patterns[0]='/(@《@)/';
        $patterns[1]='/(@\|@)/';
        $patterns[2]='/(@4@)/';
        $patterns[3]='/(@9@)/';
        $patterns[4]='/(@0@)/';
        $patterns[5]='/(@\-@)/';
        $keywords=array();
        $keywords[0]=',';
        $keywords[1]=';';
        $keywords[2]='$';
        $keywords[3]='(';
        $keywords[4]=')';
        $keywords[5]='`';
        return $str=preg_replace($patterns,$keywords,$str);
    }
    //连接数据库
    function mysqlCont(){
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);   //设置PDO显示异常
        } catch (PDOException $e) {
            echo '数据库连接失败' . $e->getMessage();
        }
        return $pdo;
    }
}