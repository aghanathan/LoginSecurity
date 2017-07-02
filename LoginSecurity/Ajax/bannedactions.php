<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "../config/config.inc.php";
@include "../session_member.php";

$act = $_GET['act'];
$id = $_GET['id'];

// Sanitize $_GET parameters to avoid XSS and other attacks
if(strpos(strtolower($id), 'union') || strpos(strtolower($id), 'select') || strpos(strtolower($id), '/*') || strpos(strtolower($id), '*/')) {
   echo "<div class=\"alert alert-warning col-lg-3 col-offset-6 centered col-centered\">
  <strong>Warning!</strong> SQL injection attempt detected.</div>";
   die;
}

if ($act=='del'){
	mysqli_query($con,"DELETE FROM banned WHERE id='$id'");
	mysqli_close($con);
	echo "<script language='javascript'>alert('Data Deleted.');</script>";
}

if ($act=='add'){
	if (!filter_var($_POST[ipaddr], FILTER_VALIDATE_IP) === false) {	
		// make sure the ip address is unique
		$query = mysqli_query($con,"SELECT * FROM banned WHERE ipaddr = '$_POST[ipaddr]'");
		$match = mysqli_num_rows($query);
		if ($match > 0){
			echo "<script language='javascript'>alert('This IP Address already banned.');
			document.location='../page.php?page=banned';</script>";
			exit();
		}
		mysqli_query($con,"INSERT INTO banned (`id` ,`ipaddr`) VALUES (NULL, '$_POST[ipaddr]')");
		mysqli_close($con);
		echo "<script language='javascript'>alert('Data Added.');
		document.location='../page.php?page=banned';</script>";
	} else {
		echo "<script language='javascript'>alert('$_POST[ipaddr] is not a valid IP address');
		document.location='../page.php?page=banned';</script>";
	}
}
?>
