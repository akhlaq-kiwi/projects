<?php
require('../includes/config.php');
$auth->checkLogin('admin');
$associate_id = isset($_GET['associate_id'])?$_GET['associate_id']:'';

if (isset($_POST) && $_POST['submit']!='') {
	$user = $_POST['user'];
	unset($_POST['user']);
	
	if($associate_id==''){
		if(!$DB->getNumBySql("select * from user where email='".$user['email']."' or login_id='".$user['login_id']."'")){
			$_POST['status'] = 1;
			$user['user_type'] = 'associate';
			$user['status'] = 1;
			$user_id = $DB->save('user',$user);
			$_POST['user_id'] = $user_id;
			$DB->save('associate',$_POST);
			$auth->setMsg("Associate Added Successfully!");
			$auth->redirect('associate_list.php');
		}else{
			$auth->setMsg("Email or Login Id already exists!");
		}
	}else{
		$DB->update('associate',$_POST, array('associate_id'=>$associate_id), 'and');
		$auth->setMsg("Associate Updated Successfully!");
		$auth->redirect('associate_list.php');
	}
	
}

if (isset($associate_id) && $associate_id!='') {
	$disabled = 'disabled="disabled"';
	$data = $DB->select('associate', array('associate_id' => $associate_id));
	$user_data = $DB->select('user', array('user_id' => $data['user_id']));;
}
if (isset($_POST) && $_POST['submit']!='') {
	$data = $_POST;
	$user_data = $user;
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Associate - Better Life Infotech</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">
<div class="container">
<?php include('header.php');?>


<div class="sidebar">
<?php include('left-sidebar.php');?>
</div>
<div class="inner_container">
	<table width="100%">
		<tr>
			<td><h1>Hello Admin!</h1></td>
		</tr>
	</table>
	<?php $auth->showMsg();?>
	<form name="associate" action="new_associate.php<?php echo $associate_id!=''?'?associate_id='.$associate_id:'';?>" method="post" >
	<table width="100%">
		<tr>
			<td colspan="2"><h1>New Associate!</h1></td>
		</tr>
		<tr>
			<td>Name:</td><td><input type="text" name="associate_name" value="<?php echo $data['associate_name'];?>" /></td>
		</tr>
		<tr>
			<td>Login Id:</td><td><input type="text" <?php echo $disabled;?> name="user[login_id]" value="<?php echo $user_data['login_id'];?>" /></td>
		</tr>
		<tr>
			<td>Email Id:</td><td><input type="text" <?php echo $disabled;?> name="user[email]" value="<?php echo $user_data['email'];?>" /></td>
		</tr>
		<tr>
			<td>Password:</td><td><input type="password" <?php echo $disabled;?> name="user[password]" value="<?php echo $user_data['password'];?>" /></td>
		</tr>

		<tr>
			<td>Level:</td><td><select name="level">
				<option value="">Select Level</option>
				<?php for($i=1; $i<=10; $i++) {?>
					<option <?php if($data['level']==$i){ echo 'selected="selected"'; }?> value="<?php echo $i;?>">Level <?php echo $i;?></option>
				<?php	}?>

			</select>
			</td>
		</tr>
		<tr>
			<td></td><td><input type="submit" name="submit" value="Save!" /></td>
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
