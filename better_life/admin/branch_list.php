<?php
require('../includes/config.php');
$auth->checkLogin('admin');

if (isset($_GET['delete_branch_id']) && $_GET['delete_branch_id']!='') {
	$DB->delete('branch', array('branch_id'=>$_GET['delete_branch_id'],'and'));
	$auth->redirect('branch_list.php');
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
		<?php $branch_list = $DB->fetchWithPagination('select * from branch where 1');?>
<?php $auth->showMsg();?>
	<table width="100%">
		<tr>
			<td><h1>Branch List</h1></td>
		</tr>
		<tr>
			<td>
			<table width="100%">
				<tr>
					<th>S.No.</th>
					<th>Branch Id</th>
					<th>Branch Name</th>
					<th>Branch Address</th>
					<th>Region</th>
					<th>Fax</th>
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				<?php if (is_array($branch_list) && count($branch_list)) {
					$i=1;
					foreach($branch_list as $bl){
					?>
					<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $bl['branch_id'];?></td>
					<td><?php echo $bl['branch_name'];?></td>
					<td><?php echo $bl['address'];?></td>
					<td><?php echo $bl['region'];?></td>
					<td><?php echo $bl['fax'];?></td>
					<td><?php echo $status_array[$bl['status']];?></td>
					<td><a href="new_branch.php?branch_id=<?php echo $bl['branch_id'];?>">Edit</a></td>
					<td><a href="branch_list.php?delete_branch_id=<?php echo $bl['branch_id'];?>">Delete</a></td>
				</tr>
				<?php $i++; } }?>
				
			</table>
			<?php echo $DB->pagination_string;?>
			</td>
		</tr>
	</table>
</div>



</div>






<?php include('footer.php');?>


</div>
</div>
</body>
</html>