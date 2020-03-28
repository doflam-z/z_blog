<?php
include "class/articleaccess.class.php";
    if (isset($_POST["save"]) or isset($_POST["publish"])){
        $access=new ArticleAccess();
        $access->articleSave();
        exit;
    }
?>
<!DOCTYPE html>
<html>
<header>
    <title>写文章</title>
    <link rel="stylesheet" href="editormd/css/editormd.css" />
    <style type="text/css">
        body{
            margin: 0px;
            padding: 0px;
        }
        .sub{
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 14px;
            color: #fbfdff;
        }
        #nav a:hover{ color: #fff}
    </style>
</header>
<body>
<form action="" method="POST">
    <div id="nav" style="height: 40px">
        <span style="line-height: 40px;position: relative;left: 20px;"><a style="color: #0e0e0e;text-decoration: none" href="admin/index.php">返回管理</a>&nbsp;&nbsp;&nbsp;标题&nbsp;
            <input style="width:1500px;height:30px;border-radius: 6px;font-size: 18px;" type="text" name="article_title" value="<?php echo $title?>">
            <input class="sub" style="background: #0d96dc;" type="submit" name="publish" value="发布文章">
            <input class="sub" style="background: #87a4b3;" type="submit" name="save" value="保存">
        </span>
    </div>
    <div id="test-editor">
        <textarea style="display:none;" name="mark"><?php echo $content?></textarea>
        <textarea class="editormd-html-textarea" name="post"></textarea>
    </div>
</form>
    <script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="editormd/editormd.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var editor = editormd("test-editor", {
                width  : "100%",
                height : "840",
                path   : "editormd/lib/",
                saveHTMLToTextarea : true  //该选项必须开启才能获取到html语言
            });
        });
    </script>
</body>
</html>

<!--markdwwn需要-->
<!-- <!DOCTYPE html>
<html>
<header>
    <title>写文章</title>
    <link rel="stylesheet" href="editormd/css/editormd.css" />
    <style type="text/css">
        body{
            margin: 0px;
            padding: 0px;
        }
    </style>
</header>
<body>

<div align="center">
    <form action=".php" method="POST">
        <table border="1" width="95%">

            <tr>
                <div id="test-editor">
                    <textarea style="display:none;" name="mark">### 关于 Editor.md
**Editor.md** 是一款开源的、可嵌入的 Markdown 在线编辑器（组件），基于 CodeMirror、jQuery 和 Marked 构建。</textarea>
                    <textarea class="editormd-html-textarea" name="post"></textarea>
                </div>
            </tr>

            <tr>
                <input type="submit" value="提交" style="font-size:32px;">
            </tr>

        </table>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        var editor = editormd("test-editor", {
             width  : "95%",
                 height : 350,
         path   : "editormd/lib/",
         saveHTMLToTextarea : true  //该选项必须开启才能获取到html语言
        });
    });
</script>

<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="editormd/editormd.min.js"></script>

</body>
</html> -->