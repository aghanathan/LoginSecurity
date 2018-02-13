<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "../config/config.inc.php";
@include "../session_member.php";

$act = $_GET['act'];
$id = $_GET['id'];

// Encrypt the Password
$_POST[password] = md5($_POST[password]);

// Sanitize $_GET parameters to avoid XSS and other attacks
if(strpos(strtolower($id), 'union') || strpos(strtolower($id), 'select') || strpos(strtolower($id), '/*') || strpos(strtolower($id), '*/')) {
   echo "<div class=\"alert alert-warning col-lg-3 col-offset-6 centered col-centered\">
  <strong>Warning!</strong> SQL injection attempt detected.</div>";
   die;
}

if ($act=='del'){
	mysqli_query($con,"DELETE FROM users WHERE id='$id'");
	mysqli_close($con);
	echo "<script language='javascript'>alert('Data Deleted.');
	document.location='../page.php?page=users';</script>";
}

if ($act=='add'){
	// make sure the ip address is unique
	$query = mysqli_query($con,"SELECT * FROM users WHERE username = '$_POST[username]'");
	$match = mysqli_num_rows($query);
	if ($match > 0){
		echo "<script language='javascript'>alert('This Username user has already been taken, Please choose another.');
		document.location='../page.php?page=users';</script>";
		exit();
	}
	mysqli_query($con,"INSERT INTO users (`id`,`username`,`password`,`email`) VALUES (NULL, '$_POST[username]','$_POST[password]','$_POST[email]')");
	mysqli_close($con);
	echo "<script language='javascript'>alert('Data Added.');
	document.location='../page.php?page=users';</script>";
}

if ($act=='update'){
	mysqli_query($con,"UPDATE users SET `password` =  '$_POST[password]',
										`email` =  '$_POST[email]' 
									WHERE `id` = '$id'");
	mysqli_close($con);
	echo "<script language='javascript'>alert('Data Updated.');
	document.location='../page.php?page=users';</script>";
}
?>
