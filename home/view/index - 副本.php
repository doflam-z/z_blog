<?php
//session_start();
if ($_SESSION['isLogin']){}else{
    header('Location:/login');
}
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
            <li><a href="#">网络</a></li>
            <li><a href="#">php</a></li>
            <li>
                <a href="#">linux</a>
                <ul class="third-level-menu">
                    <li><a href="#">nginx</a></li>
                    <li><a href="#">frp</a></li>
                    <li><a href="#">vps</a></li>
                </ul>
            </li>
            	<li><a href="#">other</a></li>
        </ul>
    	</li>
	</ul>
	<div class="search">  
        <form>  
            <input type="text" placeholder="">  
            <button type="submit">搜索</button>  
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
			<div class="box_content">
				<h3 class="font01"><a href="/2">获取Let’s Encrypt SSL证书</a></h3><br>
				<p>Let’s Encrypt 是免费、开放和自动化的证书颁发机构</p>
				<h5>>><a href="./archives/Nginx获取Let’s Encrypt SSL证书.html">阅读全文</a></h5>
			</div>
			<div class="box_content">
				<h3 class="font01"><a href="./archives/源码安装lnmp环境.html">源码安装lnmp环境</a></h3><br>
				<p>lnmp即：linux+nginx+mysql+php环境，本文记录源码编译安装lnmp环境步骤</p>
				<h5>>><a href="./archives/源码安装lnmp环境.html">阅读全文</a></h5>
			</div>
			<div class="box_content">
				<h3 class="font01"><a href="./archives/搭建SAMBA服务器.html">Centos7搭建SAMBA服务器</a></h3><br>
				<p>Samba，是种用来让UNIX系列的操作系统与微软Windows操作系统的SMB/CIFS网络协议做链接的自由软件</p>
				<h5>>><a href="./archives/搭建SAMBA服务器.html">阅读全文</a></h5>
			</div>
			<div class="box_content">
				<h3 class="font01"><a href="./archives/centos7下smartctl安装配置.html">Centos7下smartctl安装配置</a></h3>
				<p>Smartctl（S.M.A.R.T 自监控，分析和报告技术）是类Unix系统下实施SMART任务命令行套件或工具</p>
				<h5>>><a href="./archives/centos7下smartctl安装配置.html">阅读全文</a></h5>
			</div>
			<div class="box_content">
				<h3 class="font01"><a href="./archives/centos7安装v2ray启用nginx+ws+tls.html">centos7安装v2ray启用nginx+ws+tls</a></h3>
				<p>v2ray+nginx+ws+tls 是目前最稳定的科学上网方案</p>
				<h5>>><a href="./archives/centos7安装v2ray启用nginx+ws+tls.html">阅读全文</a></h5>
			</div>
			<div class="box_content">
				<h3 class="font01"><a href="./archives/centos7防火墙firewalld及iptable配置命令.html">centos7防火墙firewalld及iptable配置命令</a></h3>
				<p>Centos7版本开始不再使用iptable，转而使用firewalld防火墙</p>
				<h5>>><a href="./archives/centos7防火墙firewalld及iptable配置命令.html">阅读全文</a></h5>
			</div>
			<div class="box_footer">
				<ul>
					<li><a href="index.html">1</a></li>
					<li><a href="./archives/index-list2.html">2</a></li>
					<li><a href="#">3</a></li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>

