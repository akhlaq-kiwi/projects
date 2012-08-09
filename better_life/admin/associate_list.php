<?php
require('../includes/config.php');
$auth->checkLogin('admin');

if (isset($_GET['delete_associate_id']) && $_GET['delete_associate_id']!='') {
	$DB->delete('associate', array('associate_id'=>$_GET['delete_associate_id'],'and'));
	$auth->redirect('associate_list.php');
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Associate List - Better Life Infotech</title>
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
		<?php $associate_list = $DB->fetchWithPagination('select * from associate where 1');?>
<?php $auth->showMsg();?>
	<table width="100%">
		<tr>
			<td><h1>Associate List</h1></td>
		</tr>
		<tr>
			<td>
			<table width="100%">
				<tr>
					<th>S.No.</th>
					<th>Associate Id</th>
					<th>Associate Name</th>
					<th>Level</th>
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				<?php if (is_array($associate_list) && count($associate_list)) {
					$i=1;
					foreach($associate_list as $al){
					?>
					<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $al['associate_id'];?></td>
					<td><?php echo $al['associate_name'];?></td>
					<td><?php echo 'Level '.$al['level'];?></td>
					<td><?php echo $status_array[$al['status']];?></td>
					<td><a href="new_associate.php?associate_id=<?php echo $al['associate_id'];?>">Edit</a></td>
					<td><a href="associate_list.php?delete_associate_id=<?php echo $al['associate_id'];?>">Delete</a></td>
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