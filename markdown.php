<?php
include "class/articleaccess.class.php";
$access=new ArticleAccess();
    if (isset($_POST["save"]) or isset($_POST["publish"])){
        $access->articleSave();
        exit;
    }

    if (isset($_GET["article_id"])){
        $id=$_GET["article_id"];
        $teblename=$_GET["tablename"];
        $result=$access->take($id,$teblename);
        $title= $result["title"];
        $content=$result["content"];
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
        .button{
            border-radius: 6px;
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 6px 8px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;/*添加按钮hover*/
        }
        .button1{
            /*box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);*/
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
            background: #0d96dc;
        }
        .button1:hover{
            /*box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);*/
            background-color: #084f73;
        }
        .button2{
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);/*添加按钮阴影*/
            background: #87a4b3;
        }
        .button2:hover{
            background: #44555f;
        }
        #nav a{
            color: #87a4b3;
            text-decoration: none;
        }
        #nav a:hover{
            color: #0d96dc;
        }
    </style>
</header>
<body>
<form action="" method="POST">
    <div id="nav" style="height: 40px">
        <span style="line-height: 40px;position: relative;left: 20px;color: #57555f;"><a  href="admin/index.php">返回管理</a>&nbsp;&nbsp;&nbsp;标题=>
            <input style="width:1500px;height:30px;border-radius: 6px;font-size: 18px;" type="text" name="article_title" value="<?php echo $title?>">
            <button class="button button1" type="submit" name="publish">发布文章</button>
            <button class="button button2" type="submit" name="save">保存</button>
            <select name="category" style="color: #0e0e0e;padding: 2px 4px;border-radius: 6px">
                <?php echo $access->category();?>
            </select>
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