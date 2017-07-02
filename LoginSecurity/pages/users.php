<script>
function FunctionDelete(id) {
    var r = confirm("Are You Sure?");
    if (r == true) {
        $.get("./Ajax/useractions.php?act=del&id=" + id, function(data, status){
			// alert("Data: " + data + "\nStatus: " + status);
			document.location='./page.php?page=users';
		});
    }
}
</script>
<div class="row">
	<div class="pull-right" style="padding-bottom: 20px">
		<a data-toggle="modal" data-target="#usuario" href="#" class="btn btn-primary">Add new user <i class="fa fa-plus"></i></a>
	</div>
</div>
<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-list"></span> Users
    </div>
    <div class="panel-body">
		<div class="table-responsive">
			<?php include './pages/userspagging.php'; ?>		
            <table class="table table-bordered table-hover">
				<thead>
					<tr class="bg-primary">
						<th>ID</th>						
						<th>Username</th>
						<th>Email</th>
						<th>Action</th>						
					</tr>
				</thead>
				<tbody>
					<?php								
					$SQLshow = mysqli_query($con,"SELECT * FROM users ORDER BY id ASC limit $offset, $dataperPage");
					$noUrut = 1;
					while($row = mysqli_fetch_array($SQLshow)){
					?>
					<tr>            
						<td><?php echo $row[id]; ?></td>						
						<td><?php echo $row[username]; ?></td>
						<td><?php echo $row[email]; ?></td>
						<td>
							<center>
								<a href="./page.php?page=edituser&id=<?php echo $row[id]; ?>">
									<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
								</a>
								<a href="#" OnClick="FunctionDelete(<?php echo $row[id]; ?>)">
									<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
								</a>
							</center>
						</td>
					</tr>
					<?php 
					$noUrut++;
					}
					?>
				</tbody>
			</table>
		</div>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-6">
				<?php
				$query = mysqli_query($con,"SELECT COUNT(*) jumData from users");
				$data = mysqli_fetch_array($query);
				$jumlahData = $data["jumData"];
				?>
                <h5>Total Count <span class="label label-info"><?php echo $jumlahData; ?></span></h5>
            </div>
			<div class="col-md-6">
                <ul class="pagination pagination-sm pull-right">
					<?php include './pages/usersviewpage.php';?>                    
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="fade modal" id="usuario">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title" id="myModalLabel">Add new user</h2>						
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="myForm" name="myForm" onsubmit="return validateForm()" enctype="multipart/form-data" action="./Ajax/useractions.php?act=add">
					<fieldset>
						<!-- Form Name -->
						<!-- Prepended text-->							
						<div class="form-group">
							<label class="col-md-4 control-label" for="username">Username</label>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input id="username" name="username" class="form-control" placeholder="Username" type="text" value="" required="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="password">Password</label>
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input id="password" name="password" type="password" class="form-control input-md" value="" required="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="email">e-mail</label>
							<div class="col-md-5">
								<div class="input-group">
									<input id="email" name="email" class="form-control" placeholder="Email" type="email" value="">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								</div>
							</div>
						</div>
						<!-- File Button -->
						<div class="form-group col-lg-3 col-offset-6 pull-right">
							<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>Save</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>