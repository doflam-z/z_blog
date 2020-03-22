<?php
$str=$_POST["search_str"];
$_SESSION["a"]=1;
include "models/cont.init.php";
include "models/mysql.php";
include "class/page.class.php";
include "class/maindisplay.class.php";
echo "<pre>";
print_r($_GET);
echo "</pre>";
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>zany blog</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link href="public/css/blog.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="mainnav">
	<ul class="top-level-menu">
    <li><a href="/?home">首页</a></li>
    <li>
        <a href="#">文章分类</a>
        <ul class="second-level-menu">
            <li><a href="/?nav=net">网络</a></li>
            <li><a href="/?nav=php">php</a></li>
            <li>
                <a href="/?nav=linux">linux</a>
                <ul class="third-level-menu">
                    <li><a href="/?nav=th1">nginx</a></li>
                    <li><a href="/?nav=th2">frp</a></li>
                    <li><a href="/?nav=th3">vps</a></li>
                </ul>
            </li>
            	<li><a href="/?nav=other">other</a></li>
        </ul>
    	</li>
	</ul>
	<div class="search">  
        <form action="" method="get">
            <input type="text" name="search_str" placeholder="输入关键字进行搜索" value="<?php echo $str;?>">
            <input type="submit" name="search" value="搜索">
        </form>  
    </div> 
	</div>
	<div class="box">
		<div class="box_head">
			<div class="box_head_title">
				<h1 class="font01"><a href="/?home">ZANY</a></h1>
				<span>没有喧嚣 只有宁静围绕 我 慢慢睡着 天 刚刚破晓</span>
			</div>
            <div style="width: 200px;height: 20px;float: right;position: absolute;right: 200px;">当前用户：<?php echo $_SESSION['user_name'];?></div>
		</div>
		<div class="box_main">
            <?php
            $display=new MainDisplay();
            if(isset($_GET["search"])){
                $display-> search();
            }elseif(isset($_GET["nav"])){
                $display->category();
            }else{
                $display->fpage();
            }
            ?>
		</div>
	</div>
</body>
</html>

