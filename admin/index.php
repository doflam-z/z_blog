<?php
//后台入口
//include "../models/cont.init.php";
include "../class/page.class.php";
include "../class/maindisplay.class.php";
include "../class/articleaccess.class.php";

$access=new ArticleAccess();
$display=new MainDisplay();
switch ($_GET["menu"]){
    case "article":$main_display=$display->article_manage();$position=1;
        break;
    case "article_draft":$main_display=$display->article_draft();$position=1;
        break;
    case "article_display":$main_display=$access->articleDisplay();$position=1;
        break;
    case "cate_add":$main_display=$display->newcate();$position=2;
        break;
    case "cate_edit":$main_display=$display->newcate();$position=2;
        break;
    case "cate":$main_display=$display->cate_manage();$position=2;
        break;
    case "comment":$main_display=$display->comment_manage();$position=3;
        break;
    default:$main_display=$display->article_manage();$position=1;
}
switch ($position){
    case 1:$licolor1="#2f96b4";
        break;
    case 2:$licolor2="#2f96b4";
        break;
    case 3:$licolor3="#2f96b4";
        break;
}
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
    <div class="main-top"><span>&nbsp;&nbsp;<a href="/markdown.php">写文章&nbsp;<img src="../public/image/钢笔.jpg" style="position: relative;top: 4px;"></a></span></div>
    <div class="main-left">
        <div class="logo"><h3>Z_BLOG</h3></div>
        <ul class="main-left-nav">
            <li style="background: <?php echo $licolor1;?>"><a href="?menu=article"><img src="../public/image/图标/1158848.png" >&nbsp;&nbsp;文章管理</a></li>
            <li style="background: <?php echo $licolor2;?>"><a href="?menu=cate"><img src="../public/image/图标/分类.png" >&nbsp;&nbsp;分类管理</a></li>
            <li style="background: <?php echo $licolor3;?>"><a href="?menu=comment"><img src="../public/image/图标/11211.png" >&nbsp;&nbsp;评论管理</a></li>
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
    当前用户：
    </div>

</div>
</body>
</html>
