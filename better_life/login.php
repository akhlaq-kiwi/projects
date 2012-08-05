<?php
require('includes/config.php');


if(isset($_POST) && $_POST['submit']=='Login!'){
	//print_r($_POST);
		if($_POST['email']!='' && $_POST['password']!=''){
			unset($_POST['submit']);
					
			//print_r($_POST);
			if($DB->check('user', array('email'=>$_POST['email'], 'password'=>$_POST['password']), 'and')){
				$data = $DB->select('user', array('email'=>$_POST['email'], 'password'=>$_POST['password']), 'and');
				$login_data['EMAIL']= $data['email'];
				$login_data['USERID']= $data['user_id'];
				$login_data['ROLE']= $data['user_type'];
				$auth->login($login_data);
				if($data['user_type']=='associate'){
					$auth->redirect('home.php');
				}else{
					$auth->redirect('branch-home.php');
				}
			}else{
				$auth->setMsg("Invalid Email/Password!");
			}
		}else{
			$auth->setMsg("Email/Password can not be left blank!");
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login - Better Life Infotech</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">
<div class="container">
<?php include('header.php');?>

<div class="middle_box">
<div class="middle_contaner">
<div class="news_top">
<div class="head_text">Login!</div>
</div>
<div style="clear:both;"></div>
<?php $auth->showMsg();?>
<form name="login" action="login.php" method="POST">
<table align="center">
	<tr>
		<td>Email:</td><td><input type="text" name="email" value="" /></td>
	</tr>
	<tr>
		<td>Password:</td><td><input type="password" name="password" value="" /></td>
	</tr>
	<tr>
		<td>Type:</td><td><select name="user_type" >
			<option value="associate">Associate</option>
			<option value="branch">Branch</option>
		</select></td>
	</tr>
	<tr>
		<td></td><td><input type="submit" name="submit" value="Login!" /></td>
	</tr>
	<tr>
		<td></td><td><a href="register.php">New User! Register Here!</a></td>
	</tr>
</table>

</form>



</div>
</div>


<?php include('footer.php');?>



</div>
</div>
</body>
</html>
