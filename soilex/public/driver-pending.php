<?php 
	
	include 'functions.php';
    include 'sql-query.php';

    if (isset($_GET['id'])) {

        // $sql = 'SELECT * FROM tbl_fcm_template WHERE id=\''.$_GET['id'].'\'';
        // $img_rss = mysqli_query($connect, $sql);
        // $img_rss_row = mysqli_fetch_assoc($img_rss);

        // if ($img_rss_row['image'] != "") {
        //     unlink('upload/notification/'.$img_rss_row['image']);
        // }

        Delete('tbl_driver','id='.$_GET['id'].'');

        header("location: drivers.php");
        exit;

    }

?>
	<?php 
		// create object of functions class
		$function = new functions;
		
		// create array variable to store data from database
		$data = array();
		
		if(isset($_GET['keyword'])) {	
			// check value of keyword variable
			$keyword = $function->sanitize($_GET['keyword']);
			$bind_keyword = "%".$keyword."%";
		} else {
			$keyword = "";
			$bind_keyword = $keyword;
		}
			
		if (empty($keyword)) {
			$sql_query = "SELECT * FROM tbl_driver ORDER BY id DESC";
		} else {
			$sql_query = "SELECT * FROM tbl_driver WHERE fname LIKE ? ORDER BY id DESC";
		}
		
		
		$stmt = $connect->stmt_init();
		if ($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			if (!empty($keyword)) {
				$stmt->bind_param('s', $bind_keyword);
			}
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result( 
				 $data['id'],
                $data['fname'],
                $data['sname'],
                $data['password'],
                $data['dLicense'],
                $data['gender'],
                $data['email'],
               
                $data['status'],
                $data['phone'],
			
					);
			// get total records
			$total_records = $stmt->num_rows;
		}
			
		// check page parameter
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
						
		// number of data that will be display per page		
		$offset = 10;
						
		//lets calculate the LIMIT for SQL, and save it $from
		if ($page) {
			$from 	= ($page * $offset) - $offset;
		} else {
			//if nothing was given in page request, lets load the first page
			$from = 0;	
		}	
		
		if (empty($keyword)) {
			$sql_query = "SELECT * FROM tbl_driver where status=0 ORDER BY id DESC LIMIT ?, ?";
		} else {
			$sql_query = "SELECT * FROM tbl_driver WHERE name LIKE ? ORDER BY id DESC LIMIT ?, ?";
		}
		
		$stmt_paging = $connect->stmt_init();
		if ($stmt_paging ->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			if (empty($keyword)) {
				$stmt_paging ->bind_param('ss', $from, $offset);
			} else {
				$stmt_paging ->bind_param('sss', $bind_keyword, $from, $offset);
			}
			// Execute query
			$stmt_paging ->execute();
			// store result 
			$stmt_paging ->store_result();
			$stmt_paging->bind_result(
                $data['id'],
                $data['fname'],
                $data['sname'],
                $data['password'],
                $data['dLicense'],
                $data['gender'],
                $data['email'],
               
                $data['status'],
                $data['phone'],
			);
			// for paging purpose
			$total_records_paging = $total_records; 
		}

		// if no data on database show "No Reservation is Available"
		if ($total_records_paging == 0) {
	
	?>

<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

	<!--tab start-->
	<div class="container-fluid full-width-container">
	
		<h1 class="section-title" id="services"></h1>
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="dashboard.php">Dashboard</a></li>
		  <li class="active">Approve Driver</li>
		</ol><!--breadcrum end-->
	
		<div class="section"> 

			<form id="validationForm" method="get">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<div class="lead">MANAGE Driver</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
							<div class="form-group pmd-textfield">
								<input type="text" name="keyword" class="form-control" placeholder="Search...">
							</div>
						</div>
					</div>

					<div class="table-responsive"> 
						<table cellspacing="0" cellpadding="0" class="table pmd-table table-hover" id="table-propeller">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Second Name</th>
									<th>Gender</th>
									<th>Phone</th>
                                    <th>Email</th>
                                    <th>License</th>
									<th>Status</th>
									<th width="15%">Action</th>
								</tr>
							</thead>

						</table>
						<br>
						<p align="center">whoops, no users yet!</p>
						<br>
					</div>
				</div>
			</div> <!-- section content end -->  
			<?php $function->doPages($offset, 'driver-pending.php', '', $total_records, $keyword); ?>
			</form>
		</div>
			
	</div><!-- tab end -->

</div><!--end content area-->

<?php } else { $row_number = $from + 1; ?>

<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

	<!--tab start-->
	<div class="container-fluid full-width-container">
	
		<h1 class="section-title" id="services"></h1>
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="dashboard.php">Dashboard</a></li>
		  <li class="active">Manage Driver</li>
		</ol><!--breadcrum end-->
	
		<div class="section"> 

			<form id="validationForm" method="get">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<div class="lead">MANAGE Driver</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
							<div class="form-group pmd-textfield">
								<input type="text" name="keyword" class="form-control" placeholder="Search...">
							</div>
						</div>
					</div>

					<div class="table-responsive"> 
						<table cellspacing="0" cellpadding="0" class="table pmd-table table-hover" id="table-propeller">
							<thead>
								<tr>
                                    <th>First Name</th>
									<th>Second Name</th>
									<th>Gender</th>
									<th>Email</th>
                                    <th>Phone</th>
                                    <th>Licence</th>
									<th>Status</th>
									<th width="15%">Action</th>
								</tr>
							</thead>

							<?php 
								while ($stmt_paging->fetch()) { ?>

							<tbody>
								<tr>
									<td><?php echo $data['fname'];?></td>
									<td><?php echo $data['sname'];?></td>
									<td><?php echo $data['gender'];?></td>
                                    <td><?php echo $data['email'];?></td>
                                     <td><?php echo $data['phone'];?></td>
                                    <td><?php echo $data['dLicense'];?></td>
                                    <td><?php echo $data['status'];?></td>
									
									<td>
										<?php if ($data['status'] == '1') { ?>
										<span class="badge badge-success">PROCESSED</span>
										<?php } else if ($data['status'] == '2') { ?>
										<span class="badge">&nbsp;CANCELED&nbsp;</span>
										<?php } else { ?>
										<span class="badge badge-error">&nbsp;&nbsp;&nbsp;PENDING&nbsp;&nbsp;&nbsp;</span>
										<?php } ?>
									</td>
									<td>
									    <a href="driver-detail.php?id=<?php echo $data['id'];?>">
									        <i class="material-icons">open_in_new</i>
									    </a>
									                        
									    <a href="drivers.php?id=<?php echo $data['id'];?>" onclick="return confirm('Are you sure want to permanently delete this Driver?')" >
									                <i class="material-icons">delete</i>
									    </a>
									</td>									
								</tr>
							</tbody>

							<?php } ?>

						</table>

					</div>
				</div>
			</div> <!-- section content end -->  
			<?php $function->doPages($offset, 'drivers.php', '', $total_records, $keyword); ?>
			</form>
		</div>
			
	</div><!-- tab end -->

</div><!--end content area-->

<?php } ?>