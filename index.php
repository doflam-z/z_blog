<?php
session_start();
if ($_SESSION['isLogin']){}else{
    header('Location:/login.php');
}
$str=$_POST["search_str"];
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
    <li><a href="/">首页</a></li>
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
        <form action="" method="post">
            <input type="text" name="search_str" placeholder="输入关键字进行搜索" value="<?php echo $str;?>">
            <input type="submit" name="search" value="搜索">
        </form>  
    </div> 
	</div>
	<div class="box">
		<div class="box_head">
			<div class="box_head_title">
				<h1 class="font01"><a href="index.html">ZANY</a></h1>
				<span>没有喧嚣 只有宁静围绕 我 慢慢睡着 天 刚刚破晓</span>
			</div>
		</div>
		<div class="box_main">
            <?php
            include "class/page.class.php";
            try {
                $pdo=new PDO("mysql:host=localhost;dbname=phptest1","root","root");
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
            }catch(PDOException $e){
                echo '数据库连接失败'.$e->getMessage();
            }
            //-------------------------------------------------------------------
            $result=$pdo->query("select * from t3");
            $rows=$result->fetchAll();

            //------------------------------------------------------------------------
            $sql="select bname from t3 where btype='chengxu' ";
            $result=$pdo->query($sql);
            $rows=$result->fetchAll(PDO::FETCH_ASSOC);
            switch ($_GET["nav"]){
                case "net":
                    echo '<div class="box_content"><h3 class="font01">属于[网络]分类的文章如下</h3></div></br>';
                    foreach ($rows as $value3) {
                        echo '<div class="box_content"><h3 class="font01">' . $value3["bname"] . '</h3></div></br>';
                    }
                    break;
            }



            //------------------------------------------------------------------------

            if(isset($_POST["search"])){
                $str=$_POST["search_str"];
                $sql="select bname from t3 where bname like '%$str%'";
                $result=$pdo->query($sql);
                $rows=$result->fetchAll(PDO::FETCH_ASSOC);
                if ($rows !== array()) {
                    echo '<div class="box_content"><h3 class="font01">包含关键字['.$str.']的搜索结果如下</h3></div></br>';
                    foreach ($rows as $value) {
                        echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
                    }
                }else{
                    echo '<div class="box_content"><h3 class="font01">关键字['.$str.']无搜索结果</h3></div></br>';
                }
            }else{
                $total = count($rows);
                $page = new Page($total, $listRows = 6, $query = "", $ord = true);
                $sql = "select * from t3 {$page->limit}";
                $result = $pdo->query($sql);

                foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $value) {
                    echo '<div class="box_content"><h3 class="font01">' . $value["bname"] . '</h3></div></br>';
                }
                echo $page->fpage();
            }
            ?>
		</div>
	</div>
</body>
</html>

