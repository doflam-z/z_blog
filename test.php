<!--<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>test</title>
    <style type="text/css">
        .button{
            border-radius: 6px;
            border: none;
            color: white;
            padding: 6px 8px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;     /*获取鼠标焦点*/
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;/*添加按钮hover*/
        }
        .button_cateadd{background-color:#0d96dc;}
        .button_cateadd:hover{background-color: #084f73; }
    </style>
</head>
<body>
<form action="" method="post">
    <table align="center" width="300">
        <caption><h3>新增分类</h3></caption>
        <tr><td>分类名称:<input style="border-radius: 6px; height: 25px" type="text" name="cate_name"></td></tr>
        <tr><td></td></tr>
        <tr><td><button class="button button_cateadd" type="submit" name="cate_add">提交</button></td></tr>
    </table>
</form>
</body>
</html>-->
<?php
//try {
//    $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);   //设置PDO显示异常
//} catch (PDOException $e) {
//    echo '数据库连接失败' . $e->getMessage();
//}
//if (isset($_POST["publish"])){
//    $tablename="article";
//}else{
//    $tablename="draft";
//}
////---------存入方法
////$article=$_POST["test-editor-html-code"];
//$article=$_POST["mark"];
////$str=htmlChang($article);
//$query="insert into $tablename (article_title,article_content) value('<a href=?menu=article_display&title={$_POST["article_title"]}>{$_POST["article_title"]}</a>','$article')";
//$result=$pdo->exec($query);
//echo $result;
///*echo "<pre>";
//print_r($_POST);
//echo "</pre>";*/
////---------存入方法
//
////---------读取方法
////$article_title=$_GET["title"];
////$article_title="test3";
////$sql="select article_content from article where article_title='test3'";
//include "class/HyperDown/Parser.php";
//$parser = new HyperDown\Parser;
//$sql="select article_content from article where id='{$_GET["articleid"]}'";
//$result=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//$str=$result[0]["article_content"];
//$html = $parser->makeHtml($str);
/*echo "<div class=\"markdown-body editormd-preview-container\"><?php echo $html?></div>";*/

//-=-----------------------------------------------------------------------------------------------
//var_dump(isset($_POST["cate_add"]));
/*if (isset($_POST["cate_add"])) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
    } catch (PDOException $e) {
        echo '数据库连接失败' . $e->getMessage();
    }
    $sql = "insert into category (cate_name) values('{$_POST["cate_name"]}')";
    echo $sql;
    $result = $pdo->exec($sql);
    if ($result > 0) {
        echo  "新增成功";
    } else {
        echo  "执行失败";
    }

}*/
/*include "class/maindisplay.class.php";
$a=new MainDisplay();
if (isset($_POST["cate_add"])) {
    $a->newcate();
}*/

/*try {
    $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
    echo $num=$pdo->exec("insert into t1(bookname1) value ('asd')");
} catch (PDOException $e) {
    echo '数据库连接失败' . $e->getMessage();
}*/
$id="submit2";
echo "<pre>";
print_r($_POST);
echo "</pre>";
if (isset($_POST["submit2"])){echo "###############";}
?>
<form action="" method="post">
    <input type="text" name="in">
    <input type="submit" value="提交" name="submit <?php echo $id?>">
</form>
