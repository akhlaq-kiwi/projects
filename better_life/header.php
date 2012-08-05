<div class="header">
<div class="top">
<div class="left_logo"><a href="index.html" title="Better Life Infotech"><img src="images/logo.png" alt="logo" border="0" /></a></div>
<div class="top_right_part">
<form action="" method="post">
<div class="fielld">

<input type="text" value="" class="inp" /><label style=" padding-top:5px;"><a href="#">Search</a></label></div>
</form>

</div>
</div>
<div class="marque"><marquee>Welcome to Better life info tech India limited	(Flash News)</marquee></div>
<div class="navi">
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="about.html">About Us</a></li>
<li><a href="project.html">Project</a></li>
<li><a href="career.html">Career </a></li>
<li><a href="legal.html">Legal</a></li>
<li><a href="branch.html"> Brach</a></li>
<li><a href="feedback.html">Feedback</a></li>
<li><a href="contact.html">Contact Us</a></li>
<?php if($auth->USERID!=''){?>
<li><a href="logout.php">LogOut</a></li>
<?php }else{?>
<li><a href="register.php">Register</a></li>
<li><a href="login.php">Login</a></li>
<?php }?>

</ul>
</div>

<div class="banner_part">
<div class="banner"><img src="images/banner-image.png" alt="banner-image" /></div>
<div class="shedow"><img src="images/shadow.png" alt="shadow" /></div>
</div>
</div>
