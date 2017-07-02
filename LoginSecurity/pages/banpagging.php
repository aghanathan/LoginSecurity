<?php
	$query = mysqli_query($con,"SELECT COUNT(*) jumData from banned");
	$data = mysqli_fetch_array($query);
	$jumlahData = $data["jumData"];
	$dataperPage = 5;
	if(isset($_GET['hal'])) {
		$noPage= $_GET['hal'];
	} else {
		$noPage=1;
	}
	$offset = ($noPage-1)*$dataperPage;
?>