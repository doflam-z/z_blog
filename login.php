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
    session_start();

	$sql="select user_name,user_id from user where user_name='{$_POST["user_name"]}' and user_passwd='".md5($_POST["user_passwd"])."'";
	//验证账户密码
	$result=$pdo->query($sql);
    $user_id=$result->fetchAll(PDO::FETCH_ASSOC)['0']['user_id'];
/*    echo "<pre>";
    print_r($result->fetchAll(PDO::FETCH_ASSOC)['0']['user_id']);
    echo "</pre></br>";*/

	if ($result->rowCount() > 0 and $_SESSION['code']==$_POST['code']) {
        $_SESSION['user_name']=$_POST['user_name'];
        $_SESSION['user_id']=$user_id;
        $_SESSION['isLogin']=1;

		header("Location:/index.php");
	}elseif($result->rowCount() == 0){
	    echo "账号或密码错误";
    }elseif($result->rowCount() > 0 and $_SESSION['code']!==$_POST['code']){
	    echo "验证码错误";
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
			<td>输验证码：<input type="text" name="code"> <a href="" style="float: right;"><img src="/models/code.php"></a> </td>
		</tr>
		<tr><td colspan="2" align="center"><input type="submit" name="sub" value="登录"></td></tr>
	</table>
</form>
</body>
</html>