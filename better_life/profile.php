<?php
require('includes/config.php');
$auth->checkLogin();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profile - Better Life Infotech</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">
<div class="container">
<?php include('header-inner.php');?>


<div class="sidebar">
<?php include('left-sidebar.php');?>
</div>
<div class="inner_container">
	<h1>Profile</h1>
	<?php $auth->showMsg();?>
	content
</div>



</div>






<?php include('footer.php');?>


</div>
</div>
</body>
</html>
