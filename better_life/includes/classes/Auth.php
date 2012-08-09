<?php
class Auth extends General{
	var $msg = 'message';
	function __construct(){
		session_start();
		if(is_array($_SESSION) && count($_SESSION)){
			foreach($_SESSION as $k=>$v){
				$this->$k = $v;
			}
		}
	}
	function set($key='', $value=''){
		$_SESSION[$key] = $value;
	}
	function setMsg($message){
		$_SESSION[$this->msg] = $message;
	}
	function showMsg(){
		if($_SESSION[$this->msg]!=''){
			echo '<p class="msg">'.$_SESSION[$this->msg].'</p>';
			unset($_SESSION[$this->msg]);
		}
	}
	function login($data = array()){
		if(is_array($data) && count($data)){
			foreach($data as $k=>$d){
				$this->set($k, $d);
			}
		}
	}
	function logout(){
		session_destroy();
	}

	function redirect($url){
		header("Location: ".$url);
		die;
	} 

	function checkLogin($role=''){

		if($_SESSION['USERID']==''){
			$this->setMsg("You are not logged In, Please  login to view This page!");
			$this->redirect("login.php");
		}
		if($role!=$_SESSION['ROLE']){
			$this->setMsg("You dont have permission to access this page!");
			$this->redirect("login.php");
		}
	}
	function checkLoginHome($url){
		if($this->USERID!=''){
			$this->redirect($url);
		}
	}

	
}
$auth = new Auth();
?>