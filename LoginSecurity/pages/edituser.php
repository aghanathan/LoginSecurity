<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "../config/config.inc.php";
@include "../session_member.php";

$id = $_GET['id'];

// Sanitize $_GET parameters to avoid XSS and other attacks
if(strpos(strtolower($id), 'union') || strpos(strtolower($id), 'select') || strpos(strtolower($id), '/*') || strpos(strtolower($id), '*/')) {
   echo "<div class=\"alert alert-warning col-lg-3 col-offset-6 centered col-centered\">
  <strong>Warning!</strong> SQL injection attempt detected.</div>";
   die;
}

$data	= "SELECT * FROM users WHERE id='$id'";
$hasil	= mysqli_query($con,$data);
$row	= mysqli_fetch_array($hasil);
?>
<form class="form-horizontal" action="./Ajax/useractions.php?act=update&id=<?php echo $id; ?>" method="post">
    <div class="box">
		<div class="box-header">
			<h3 class="box-title">Edit User</h3>
		</div>
	    <fieldset>
		<!-- Form Name -->
		<!-- Prepended text-->							
			<div class="form-group">
				<label class="col-md-2 control-label" for="username">Username</label>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="username" name="username" class="form-control" placeholder="Username" type="text" value="<?php echo $row[username];?>" disabled>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="password">New Password</label>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" name="password" type="password" class="form-control input-md" value="<?php echo $row[password];?>" required="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="email">e-mail</label>
				<div class="col-md-4">
					<div class="input-group">
						<input id="email" name="email" class="form-control" placeholder="Email" type="email" value="<?php echo $row[email];?>">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
					</div>
				</div>
			</div>
		</fieldset>
        <div class="panel-footer">
			<button class="btn btn-flat btn-success" name="edit" type="submit">Save</button>
		</div>
	</div>
</form>