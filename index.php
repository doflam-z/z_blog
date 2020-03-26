<?php
//前台入口
//include "models/cont.init.php";//验证登录、开启session
include "class/page.class.php";
include "class/maindisplay.class.php";
//----------------------------------------------
$display=new MainDisplay();
$str=$_GET["search_str"];
$rows=$display->cateNav();
$nav1=$rows[0]["cate_name"];
$nav2=$rows[1]["cate_name"];
$nav3=$rows[2]["cate_name"];
$nav4=$rows[3]["cate_name"];
$nav5=$rows[4]["cate_name"];
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
        <a href="#"><?php echo $nav1;?></a>
        <ul class="second-level-menu">
            <li><a href="/?nav=<?php echo $nav2;?>"><?php echo $nav2;?></a></li>
            <li><a href="/?nav=<?php echo $nav3;?>"><?php echo $nav3;?></a></li>
            <li>
                <a href="/?nav=<?php echo $nav4;?>"><?php echo $nav4;?></a>
                <ul class="third-level-menu">
                    <li><a href="/?nav=th1"></a></li>
                    <li><a href="/?nav=th2">frp</a></li>
                    <li><a href="/?nav=th3">vps</a></li>
                </ul>
            </li>
            	<li><a href="/?nav=<?php echo $nav5;?>"><?php echo $nav5;?></a></li>
        </ul>
    	</li>
	</ul>
	<div class="search">  
        <form action="" method="get">
            <input type="text" name="search_str" placeholder="输入关键字进行搜索" value="<?php echo $str;?> ">
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

