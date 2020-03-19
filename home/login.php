<?php 
//后台登录页
//连接数据库判断是否连接成功
if(isset($_POST["sub"])){
	try {
	    $pdo=new PDO("mysql:host=localhost;dbname=z_blog","root","root");
	    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
	}catch(PDOException $e){
	    echo '数据库连接失败'.$e->getMessage();
	}

	$sql="select user_name from user where user_name='{$_POST["user_name"]}' and user_passwd='".md5($_POST["user_passwd"])."'";
	//验证账户密码
	// echo $sql."</br>";
	$result=$pdo->query($sql);
	echo "<pre>";
	print_r($_SESSION["code"]);
	print_r($_POST["code"]);
	echo "</pre>";
	// echo $result->rowCount();
	if ($result->rowCount() < 0 && $_POST["code"] == $_SESSION["code"]) {
		header("Location:/");
	}else{
		$error="登陆失败,账号或密码错误";
		echo $error;
		}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
<form action="" method="post">
	<table align="center" width="400" border="1" style="margin-top: 15%">
		<caption><h1>Z_BLOG-LOGIN</h1></caption>
		<tr><td>用户名称：<input type="text" name="user_name"></td></tr>
		<tr><td>用户密码：<input type="password" name="user_passwd"></td></tr>
		<tr>
			<td>输验证码：<input type="text" name="code"> <a href="" style="float: right;"><img src="/code"></a> </td>
		</tr>
		<tr><td colspan="2" align="center"><input type="submit" name="sub" value="登录"></td></tr>
	</table>
</form>
</body>
</html>