<?php
require('../includes/config.php');
$auth->checkLogin('admin');
$branch_id = isset($_GET['branch_id'])?$_GET['branch_id']:'';

if (isset($_POST) && $_POST['submit']!='') {
	$user = $_POST['user'];
	unset($_POST['user']);
	
	if($branch_id==''){
		if(!$DB->getNumBySql("select * from user where email='".$user[email]."' or login_id='".$user['login_id']."'")){
			$_POST['status'] = 1;
			$user['user_type'] = 'branch';
			$user['status'] = 1;
			$user_id = $DB->save('user',$user);
			$_POST['user_id'] = $user_id;
			$DB->save('branch',$_POST);
			$auth->setMsg("Branch Added Successfully!");
			$auth->redirect('branch_list.php');
		}else{
			$auth->setMsg("Email or Login Id already exists!");
		}
	}else{
		$DB->update('branch',$_POST, array('branch_id'=>$branch_id), 'and');
		$auth->setMsg("Branch Updated Successfully!");
		$auth->redirect('branch_list.php');
	}
	
}

if (isset($branch_id) && $branch_id!='') {
	$disabled = 'disabled="disabled"';
	$data = $DB->select('branch', array('branch_id' => $branch_id));
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
<title>New Branch - Better Life Infotech</title>
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
	<form name="branch" action="new_branch.php<?php echo $branch_id!=''?'?branch_id='.$branch_id:'';?>" method="post" >
	<table width="100%">
		<tr>
			<td colspan="2"><h1>New Branch!</h1></td>
		</tr>
		<tr>
			<td>Name:</td><td><input type="text" name="branch_name" value="<?php echo $data['branch_name'];?>" /></td>
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
			<td>Nearest Branch:</td><td><select name="nearest_branch">
				<option value="">Select Branch</option>
				<?php 
					$branch_list = $DB->select('branch', array(1 => 1), 'and', 'all');
					if(is_array($branch_list) and count($branch_list)){
						foreach ($branch_list as $bl) {?>
							<option <?php if($data['branch_id']==$bl['branch_id']){ echo 'selected="selected"'; }?> value="<?php echo $bl['branch_id'];?>"><?php echo $bl['branch_name'];?></option>
					<?php	}
					}
				?>

			</select>
			</td>
		</tr>
		<tr>
			<td>Region:</td><td><input type="text" name="region" value="<?php echo $data['region'];?>" /></td>
		</tr>
		<tr>
			<td>Address:</td><td><textarea name="address"><?php echo $data['address'];?></textarea></td>
		</tr>
		<tr>
			<td>Mobile/Phone No:</td><td><input type="text" name="contact_no" value="<?php echo $data['contact_no'];?>" /></td>
		</tr>
		<tr>
			<td>Fax:</td><td><input type="text" name="fax" value="<?php echo $data['fax'];?>" /></td>
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
