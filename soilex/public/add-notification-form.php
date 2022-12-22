<?php include_once('functions.php'); ?>

<?php

	if (isset($_POST['btnAdd'])) {

        $title   = $_POST['title'];
        $message = $_POST['message'];
		$link	 = $_POST['link'];

        $image = $_FILES['image']['name'];
        $image_error = $_FILES['image']['error'];
        $image_type = $_FILES['image']['type'];
				
		// create array variable to handle error
		$error = array();

        if (empty($title)) {
            $error['title'] = " <span class='label label-danger'>Must Insert!</span>";
        }
			
		if (empty($message)) {
			$error['message'] = " <span class='label label-danger'>Must Insert!</span>";
		}

        // common image file extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // get image file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["image"]["name"]));

        if($image_error > 0) {
            $error['image'] = " <span class='font-12 col-red'>This field is required.</span>";
        } else if(!(($image_type == "image/gif") ||
                ($image_type == "image/jpeg") ||
                ($image_type == "image/jpg") ||
                ($image_type == "image/x-png") ||
                ($image_type == "image/png") ||
                ($image_type == "image/pjpeg")) &&
            !(in_array($extension, $allowedExts))) {

            $error['image'] = " <span class='font-12'>Image type must jpg, jpeg, gif, or png!</span>";
        }
			
		if (!empty($title) && !empty($message) && empty($error['image'])) {

            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['image']['name']);
            $function = new functions;
            $image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], 'upload/notification/'.$image);        	
            $upload_image = $image;

			// insert new data to menu table
			$sql_query = "INSERT INTO tbl_fcm_template (title, message, image, link) VALUES (?, ?, ?, ?)";
					
			$stmt = $connect->stmt_init();
			if ($stmt->prepare($sql_query)) {	
				// Bind your variables to replace the ?s
				$stmt->bind_param('ssss', $title, $message, $upload_image, $link);
				// Execute query
				$stmt->execute();
				// store result 
				$result = $stmt->store_result();
				$stmt->close();
			}

			if($result) {
		        $succes =<<<EOF
					<script>
					alert('New Push Notification Template Added Successfully...');
					window.location = 'manage-notification.php';
					</script>
EOF;
				echo $succes;
		    } else {
		        $error['add_notification'] = "<br><div class='alert alert-danger'>Added Failed</div>";
		    }
		}
	}

?>

<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

	<!--tab start-->
	<div class="container-fluid full-width-container">
		<h1></h1>
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="dashboard.php">Dashboard</a></li>
		  <li class="active">Add Notification</li>
		</ol>
		<!--breadcrum end-->
	
		<div class="section"> 

			<form id="validationForm" method="post" enctype="multipart/form-data">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="lead">ADD NOTIFICATION</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="title" class="control-label">
									Title *
								</label>
								<input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
							</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="message" class="control-label">
									Message *
								</label>
								<input type="text" name="message" id="message" class="form-control" placeholder="Message" required>
							</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="regular1" class="control-label">Big Image ( jpg / png) *</label>
								<input type="file" name="image" id="image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" required />
							</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="message" class="control-label">
									Url (Optional)
								</label>
								<input type="text" name="link" id="link" class="form-control" placeholder="http://www.your-url.com">
							</div>
						</div>
					</div>

				</div>

				<div class="pmd-card-actions">
					<p align="right">
					<button type="submit" class="btn pmd-ripple-effect btn-danger" name="btnAdd">Submit</button>
					</p>
				</div>
			</div> <!-- section content end -->  
			</form>
		</div>
			
	</div><!-- tab end -->

</div><!--end content area -->