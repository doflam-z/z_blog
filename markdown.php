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
    </style>
</header>
<body>
<!--    <div id="nav" style="width: 100%;height: 50px;">
        <a href="#"></a>
        <form action="/admin/index.php" method="post">
            <a href="#" style="text-decoration: none;color: #0e0e0e">标题</a>
            <input type="text" name="article_title">
            <input type="submit" name="sub_article" value="发布文章">
        </form>
    </div>-->
<form action="test.php" method="POST">
    <div id="test-editor">
        <textarea style="display:none;">### 关于 Editor.md

    **Editor.md** 是一款开源的、可嵌入的 Markdown 在线编辑器（组件），基于 CodeMirror、jQuery 和 Marked 构建。
    ## php   ```php  if(a>10) echo "########";```
        </textarea>
        <textarea class="editormd-html-textarea" name="post"></textarea>
    </div>
    <input type="submit" value="发布">
</form>
    <script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="editormd/editormd.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var editor = editormd("test-editor", {
    /*            width  : "100%",
                height : "100%",*/
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