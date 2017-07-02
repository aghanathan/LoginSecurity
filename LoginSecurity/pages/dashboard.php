<div class="panel panel-default">
    <div class="panel-heading">Dashboard</div>
    <div class="panel-body">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.	
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-list"></span> Login Log
    </div>
    <div class="panel-body">
		<div class="table-responsive">
			<?php include './pages/loginpagging.php'; ?>
            <table class="table table-bordered table-hover">
				<thead>
					<tr class="bg-primary">
						<th>ID</th>
						<th>Username</th>
						<th>IP Address</th>
						<th>Location</th>
						<th>Login Time</th>
					</tr>
				</thead>
				<tbody>
					<?php								
					$SQLshow = mysqli_query($con,"SELECT * FROM ipslog ORDER BY id DESC limit $offset, $dataperPage");
					$noUrut = 1;
					while($row = mysqli_fetch_array($SQLshow)){
					?>
					<tr>
						<td><?php echo $row[id]; ?></td>
						<td><?php echo $row[username]; ?></td>
						<td><a href="http://ipinfo.io/<?php echo $row[ipaddr]; ?>" target="_blank"><?php echo $row[ipaddr]; ?></a></td> 
						<td><?php echo $row[location]; ?></td>
						<?php $date = date_create($row[login]); ?>
						<td><?php echo date_format($date,"M dS h:i:sa"); ?></td>
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
				$query = mysqli_query($con,"SELECT COUNT(*) jumData from ipslog");
				$data = mysqli_fetch_array($query);
				$jumlahData = $data["jumData"];
				?>
                <h5>Total Count <span class="label label-info"><?php echo $jumlahData; ?></span></h5>
            </div>
            <div class="col-md-6">
                <ul class="pagination pagination-sm pull-right">
					<?php include './pages/loginviewpage.php';?>                    
                </ul>
            </div>
        </div>
    </div>
</div>
