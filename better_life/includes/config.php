<?php
// Report all errors except E_NOTICE
// This is the default value set in php.ini

error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('classes/DB.php');
include('classes/General.php');
include('classes/Auth.php');
include('classes/User.php');
include('classes/Image.php');



?>