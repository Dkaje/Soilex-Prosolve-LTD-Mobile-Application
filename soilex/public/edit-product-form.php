<?php

    include('public/sql-query.php');

	if (isset($_GET['product_id'])) {
 		$qry 	= "SELECT * FROM tbl_product WHERE product_id ='".$_GET['product_id']."'";
		$result = mysqli_query($connect, $qry);
		$row 	= mysqli_fetch_assoc($result);
 	}

	if(isset($_POST['submit'])) {

		if ($_FILES['product_image']['name'] != '') {
			unlink('upload/product/'.$_POST['old_image']);
			$product_image = time().'_'.$_FILES['product_image']['name'];
			$pic2 = $_FILES['product_image']['tmp_name'];
   			$tpath2 = 'upload/product/'.$product_image;
			copy($pic2, $tpath2);
		} else {
			$product_image = $_POST['old_image'];
		}
 
		$data = array(											 

			'product_name'  		=> $_POST['product_name'],
			'product_price'  		=> $_POST['product_price'],
			'product_status'  		=> $_POST['product_status'],
			'product_image' 		=> $product_image,
            'product_description'	=> $_POST['product_description'],
            'product_quantity'		=> $_POST['product_quantity'],
            'category_id'  			=> $_POST['category_id']

		);	

			$hasil = Update('tbl_product', $data, "WHERE product_id = '".$_POST['product_id']."'");

			if ($hasil > 0) {
			//$_SESSION['msg'] = "";
		        $succes =<<<EOF
					<script>
					alert('Product successfully updated...');
					window.location = 'manage-product.php';
					</script>
EOF;
				echo $succes;
			exit;
			}

	}

 	$sql_query = "SELECT * FROM tbl_category ORDER BY category_name ASC";
	$ringtone_qry_cat = mysqli_query($connect, $sql_query);

	$sql_currency = "SELECT currency_code FROM tbl_config, tbl_currency WHERE tbl_config.currency_id = tbl_currency.currency_id";
	$sql_result = mysqli_query($connect, $sql_currency);
	$row_currency = mysqli_fetch_assoc($sql_result);

?>

<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

	<!--tab start-->
	<div class="container-fluid full-width-container">
		<h1></h1>
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="dashboard.php">Dashboard</a></li>
		  <li class="active">Edit Product</li>
		</ol>
		<!--breadcrum end-->
	
		<div class="section"> 

			<form id="validationForm" method="post" enctype="multipart/form-data">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="lead">EDIT PRODUCT</div>
						</div>
					</div>

					<div class="group-fields clearfix row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="product_name" class="control-label">Product Name *</label>
								<input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="<?php echo $row['product_name'];?>" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="product_price" class="control-label">Product Price ( <?php echo $row_currency["currency_code"]; ?> ) *</label>
								<input type="text" name="product_price" id="product_price" class="form-control" placeholder="50" value="<?php echo $row['product_price'];?>" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="product_quantity" class="control-label">Product Quantity *</label>
								<input type="number" name="product_quantity" id="product_quantity" class="form-control" placeholder="0" value="<?php echo $row['product_quantity'];?>" required>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">       
								<label>Category *</label>
								<select class="select-with-search form-control pmd-select2" name="category_id" id="category_id">
									<?php															 
										while($r_c_row = mysqli_fetch_array($ringtone_qry_cat)) {
										$sel = '';
										if ($r_c_row['category_id'] == $row['category_id']) {
											$sel = "selected";	
										}	
									?>
									<option value="<?php echo $r_c_row['category_id'];?>" <?php echo $sel; ?>><?php echo $r_c_row['category_name'];?></option>
									<?php }?>
								</select>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">       
								<label>Status *</label>
								<select class="select-simple form-control pmd-select2" name="product_status">
									<option <?php if($row['product_status'] == 'Available'){ echo 'selected';} ?> value="Available">Available</option>
									<option <?php if($row['product_status'] == 'Sold Out'){echo 'selected';} ?> value="Sold Out">Sold Out</option>
								</select>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="regular1" class="control-label">Product Image ( jpg / png ) *</label>
								<input type="file" name="product_image" id="product_image" id="product_image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/product/<?php echo $row['product_image'];?>" data-show-remove="false" />
							</div>
						</div>						

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
								<label class="control-label">Product Description *</label>
  								<textarea required class="form-control" name="product_description"><?php echo $row['product_description'];?></textarea>
  								<script>                             
									CKEDITOR.replace( 'product_description' );
								</script>	
							</div>
						</div>

						<input type="hidden" name="old_image" value="<?php echo $row['product_image'];?>">
						<input type="hidden" name="product_id" value="<?php echo $row['product_id'];?>">

						<div class="pmd-card-actions col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<p align="right">
							<button type="submit" class="btn pmd-ripple-effect btn-danger" name="submit">UPDATE</button>
							</p>
						</div>						

						</div>

				</div>

			</div> <!-- section content end -->  
			</form>
		</div>
			
	</div><!-- tab end -->

</div><!--end content area