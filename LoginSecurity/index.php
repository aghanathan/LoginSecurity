<?php
date_default_timezone_set('Australia/Victoria');
error_reporting(E_ALL ^ E_NOTICE);
@include "./config/config.inc.php";
session_start();

$user = mysqli_real_escape_string($con, $_POST['username']);
$pass = mysqli_real_escape_string($con, $_POST['password']);

if ($user AND $pass){
	$login = mysqli_query($con,"SELECT * FROM users WHERE username = '$user' AND password = '$pass'");
	$match = mysqli_num_rows($login);
	$r     = mysqli_fetch_array($login);
	if ($match > 0){
		session_start();
		$_SESSION[username] = $r[username];
		$_SESSION[password] = $r[password];
		
		$ip = get_client_ip();
		$checkip = mysqli_query($con,"SELECT * FROM banned WHERE ipaddr = '$ip'");
		$found = mysqli_num_rows($checkip);
		if ($found > 0){
			echo "<script>window.alert('Your IP Address Has Been Banned');</script>";
		} else {
			$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
			$location = $details->city.", ".$details->country;

			mysqli_query($con,"INSERT INTO ipslog (`id` ,
												`username` ,
												`ipaddr` ,
												`location` ,
												`login`)
										VALUES (NULL,  
												'$_SESSION[username]',
												'$ip',									
												'$location',
												NOW())");
			mysqli_close($con);		
		
			echo "<script>window.location='./page.php?page=dashboard'</script>";
		}
	} else {
		echo "<script>window.alert('wrong username or password');</script>";
	}
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>:: Login Security ::</title>
<link href="./bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<style>  
.container {
	padding-top:150px;
}
.panel-default {
    opacity: .9;
    -webkit-box-shadow: 0px 7px 24px 1px rgba(0,0,0,0.45);
    -moz-box-shadow: 0px 7px 24px 1px rgba(0,0,0,0.45);
    box-shadow: 0px 7px 24px 1px rgba(0,0,0,0.45);    
}
</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<form method="post" class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<fieldset>
							<div class="row" style="margin-top:20px">
								<div class="col-sm-12 col-md-10  col-md-offset-1 ">
									<div class="form-group">
										<label>Username:</label>
										<div class="input-group"> <span class="input-group-addon"> <i class="glyphicon glyphicon-user"></i> </span>
											<input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="">
										</div>
									</div>
									<div class="form-group">
										<label>Password:</label>
										<div class="input-group"> <span class="input-group-addon"> <i class="glyphicon glyphicon-lock"></i> </span>
											<input type="password" class="form-control" name="password" placeholder="Password" required="">
										</div>
									</div>								   
									<div class="form-group">
										<label><input type="checkbox">Keep me Logged in </label> 
										<input type="submit" class="btn btn-success pull-right" value="Log In">
									</div>               
								</div>
							</div>
						</fieldset>
					</form>  
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>