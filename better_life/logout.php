<?php
include('includes/config.php');
//$auth->checkLogin(3);
$auth->logout();
$auth->setMsg("You are successfully logged out!");
$auth->redirect("index.php");
?>
