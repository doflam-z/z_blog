<?php
//前台页面
//include "../models/cont.init.php";
session_start();
function __autoload($className){
    include "../class/".strtolower($className).".class.php";
}

$access=new ArticleAccess();
$display=new MainDisplay();
$usersection=new UserSection();
if (isset($_POST["sbubmit_comment"]) and isset($_SESSION["user_name"]))
{
    $access->comment();
}elseif (isset($_POST["sbubmit_comment"]) and !isset($_SESSION["user_name"])){
    echo "<script>window.alert('请登录后评论');</script>";
}
if (isset($_GET["menu"]))
{
    switch ($_GET["menu"]){
        case "article":$main_display=$display->fpage();
            break;
        case "article_display":$main_display=$access->articleDisplay();
            break;
        case "comment":$main_display=$display->comment();
            break;
        default:$main_display=$display->fpage();
    }
}elseif (isset($_GET["nav"]))
{
    $main_display=$display->category();
}elseif (isset($_GET["search"]))
{
    $main_display=$display->search();
}else{
    $main_display=$display->fpage();
}
if($_SESSION["isLogin"]){
    $status_button="注销";
    $status_url="../models/destroysession.php";
}else{
    $status_button="登录";
    $status_url="../models/login.php";
}

$str=$_GET["search_str"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>blog-admin</title>
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon" />
    <link href="../public/css/blog_admin.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../editormd/css/editormd.css" />
</head>
<body>
<div class="main">
    <div class="main-top">
        <form action="" method="get">
            <span style="position: relative;left: 1600px;">
                <input class="search_content" type="text" name="search_content" value="<?php echo $str;?> ">
                <button class="button button_search" name="search" type="submit">搜索</button>
            </span>
        </form>
    </div>
    <div class="main-left">
        <div class="logo"><h3>Z_BLOG</h3></div>
        <ul class="main-left-nav">
            <li style="background-image: url('../public/image/图标/1225491.png')"><a href="?menu=article"><img src="../public/image/图标/1158848.png" >&nbsp;&nbsp;全部文章</a></li>
            <li style="background-image: url('../public/image/图标/12254461.png')"><a><img src="../public/image/图标/分类.png" >&nbsp;&nbsp;分类导航</a>
                <ul class="second-nav">
                    <?php
                        $rows=$display->cateNav();
                        foreach($rows as $value){
                            echo "<li><a href='?nav={$value["cate_name"]}'>{$value["cate_name"]}</a></li>";
                        }
                    ?>
                </ul>
            </li>
            <li style="background-image: url('../public/image/图标/1225491.png')"><a href="?menu=comment"><img src="../public/image/图标/11211.png" >&nbsp;&nbsp;最新评论</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="content-display">
            <?php
            $display->article_delete();
            echo $main_display;
            ?>
        </div>
    </div>
    <div class="main-right">
        <div class="avatar"></div>
        <div class="user">
            <table width="260">
                <caption style="margin-bottom: 20px;">当前用户： <b style="color: #51a351;"><?php echo $_SESSION["user_name"]?></b>&nbsp;&nbsp;<a href="<?php echo $status_url?>" style="color: #e9322d"><?php echo $status_button?></a></caption>
                <tr><td>文章总数</td><td>评论总数</td><td>文章访问量</td></tr>
                <tr><td><?php echo $usersection->article_count()?></td><td><?php echo $usersection->comment_count()?></td><td><?php echo $usersection->article_read()?></td></tr>
            </table>
        </div>
    </div>

</div>
</body>
</html>
