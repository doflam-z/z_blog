<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);   //设置PDO显示异常
} catch (PDOException $e) {
    echo '数据库连接失败' . $e->getMessage();
}
if (isset($_POST["publish"])){
    $tablename="article";
}else{
    $tablename="draft";
}
//---------存入方法
//$article=$_POST["test-editor-html-code"];
$article=$_POST["mark"];
//$str=htmlChang($article);
$query="insert into $tablename (article_title,article_content) value('<a href=?menu=article_display&title={$_POST["article_title"]}>{$_POST["article_title"]}</a>','$article')";
$result=$pdo->exec($query);
echo $result;
/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
//---------存入方法

//---------读取方法
//$article_title=$_GET["title"];
//$article_title="test3";
//$sql="select article_content from article where article_title='test3'";
include "class/HyperDown/Parser.php";
$parser = new HyperDown\Parser;
$sql="select article_content from article where id='{$_GET["articleid"]}'";
$result=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$str=$result[0]["article_content"];
$html = $parser->makeHtml($str);
echo "<div class=\"markdown-body editormd-preview-container\"><?php echo $html?></div>";


//替换html冲突符号方法
function htmlChang($article)
{
    $str=htmlspecialchars($article, ENT_QUOTES);
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

//恢复html冲突符号方法
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
    $str=preg_replace($patterns,$keywords,$str);
    $article=htmlspecialchars_decode($str,ENT_QUOTES);
    return $article;
}

