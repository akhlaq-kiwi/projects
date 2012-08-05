<?php
require('includes/config.php');
if(isset($_POST) && $_POST['submit']=='Register!'){
		if($_POST['email']!='' && $_POST['password']!='' && $_POST['confirm_password']!=''){
			if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])){
				if($_POST['password']==$_POST['confirm_password']){
					
					unset($_POST['confirm_password']);
							
					if(!$DB->check('user', array('email'=>$_POST['email']))){
						if($DB->save('user', $_POST)){
							$data = $DB->select('user', array('email'=>$_POST['email'], 'password'=>$_POST['password']), 'and');
							$login_data['EMAIL']= $data['email'];
							$login_data['USERID']= $data['user_id'];
							$login_data['ROLE']= $data['user_type'];
							$auth->login($login_data);
							$auth->setMsg("Your registration done successfully!");
							if($data['user_type']=='associate'){
								$auth->redirect('home.php');
							}else{
								$auth->redirect('branch-home.php');
							}
						}else{
							$auth->setMsg("Error Occurred, Try Again!");
						}
						$auth->redirect("index.php");
					}else{
						$auth->setMsg("Email Already Exist!");
					}
				}else{
					$auth->setMsg("Password do not match!");
				}
			}else{
				$auth->setMsg("Please enter a valid email address!");
			}
		}else{
			$auth->setMsg("Some field are left blank, which are mandatory!");
		}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register - Better Life Infotech</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">
<div class="container">
<?php include('header.php');?>

<script type="text/javascript">
	function validateForm(frm){
		
		if(frm.email.value==''){
			alert("Enter Email address!");
			frm.email.focus();
			return false;
		}
		if(!validateEmail(frm.email.value)){
			alert("Enter valid Email address!");
			frm.email.focus();
			return false;
		}
		if(frm.password.value==''){
			alert("Enter your password!");
			frm.password.focus();
			return false;
		}
		if(frm.password.value!=frm.confirm_password.value){
			alert("Confirm password do not match!");
			frm.confirm_password.focus();
			return false;
		}
	}


function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
</script>

<div class="middle_box">
<div class="middle_contaner">
<div class="news_top">
<div class="head_text">Register!</div>
</div>
<div style="clear:both;"></div>
<?php $auth->showMsg();?>
<form name="login" action="register.php" method="POST">
<table align="center">
	<tr>
		<td>Email:</td><td><input type="text" name="email" value="" /></td>
	</tr>
	<tr>
		<td>Password:</td><td><input type="password" name="password" value="" /></td>
	</tr>
	<tr>
		<td>Confirm Password:</td><td><input type="password" name="confirm_password" value="" /></td>
	</tr>
	<tr>
		<td>Type:</td><td><select name="user_type" >
			<option value="associate">Associate</option>
			<option value="branch">Branch</option>
		</select></td>
	</tr>
	<tr>
		<td></td><td><input type="submit" name="submit" value="Register!" onclick="return validateForm(this.form);" /></td>
	</tr>
	<tr>
		<td></td><td><a href="login.php">Already Member? Login Here!</a></td>
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
