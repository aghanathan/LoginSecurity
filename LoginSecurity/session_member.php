<?php
session_start();
if($_SESSION['username'] == '' ){
	echo "<script>window.alert('You must login first!');
			window.location='./index.php'</script>";
	die();
}
?>