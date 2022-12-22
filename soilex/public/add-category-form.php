<?php include_once('functions.php'); ?>

<?php

if (isset($_POST['btnAdd'])) {

    $category_name = $_POST['category_name'];

    // get image info
    $menu_image = $_FILES['category_image']['name'];
    $image_error = $_FILES['category_image']['error'];
    $image_type = $_FILES['category_image']['type'];

    // create array variable to handle error
    $error = array();

    if(empty($category_name)){
        $error['category_name'] = " <span class='label label-danger'>Must Insert!</span>";
    }

    // common image file extensions
    $allowedExts = array("gif", "jpeg", "jpg", "png");

    // get image file extension
    error_reporting(E_ERROR | E_PARSE);
    $extension = end(explode(".", $_FILES["category_image"]["name"]));

    if($image_error > 0) {
        $error['category_image'] = " <span class='font-12 col-red'>You're not insert images!!</span>";
    } else if(!(($image_type == "image/gif") ||
            ($image_type == "image/jpeg") ||
            ($image_type == "image/jpg") ||
            ($image_type == "image/x-png") ||
            ($image_type == "image/png") ||
            ($image_type == "image/pjpeg")) &&
        !(in_array($extension, $allowedExts))) {

        $error['category_image'] = " <span class='font-12'>Image type must jpg, jpeg, gif, or png!</span>";
    }

    if(!empty($category_name) && empty($error['category_image'])){

        // create random image file name
        $string = '0123456789';
        $file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
        $function = new functions;
        $menu_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;

        // upload new image
        $upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/category/'.$menu_image);

        // insert new data to menu table
        $sql_query = "INSERT INTO tbl_category (category_name, category_image) VALUES(?, ?)";

        $upload_image = $menu_image;
        $stmt = $connect->stmt_init();
        if($stmt->prepare($sql_query)) {
            // Bind your variables to replace the ?s
            $stmt->bind_param('ss',
                $category_name,
                $upload_image
            );
            // Execute query
            $stmt->execute();
            // store result
            $result = $stmt->store_result();
            $stmt->close();
        }

        if($result) {
		        $succes =<<<EOF
					<script>
					alert('Category Added Successfully...');
					window.location = 'manage-category.php';
					</script>
EOF;
				echo $succes;
        } else {
            $error['add_category'] = "<br><div class='alert alert-danger'>Added Failed</div>";
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
		  <li class="active">Add Category</li>
		</ol>
		<!--breadcrum end-->
	
		<div class="section"> 

			<form id="validationForm" method="post" enctype="multipart/form-data">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="lead">ADD CATEGORY</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="category_name" class="control-label">
									Category Name *
								</label>
								<input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name" required>
							</div>
						</div>
					</div>
					<div class="group-fields clearfix row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="regular1" class="control-label">Category Image ( jpg / png) *</label>
								<input type="file" name="category_image" id="category_image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" required />
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