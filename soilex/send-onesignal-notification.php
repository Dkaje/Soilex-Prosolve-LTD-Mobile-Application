<?php include('session.php'); ?>
<?php include('public/menubar.php'); ?>

<?php 
	if (isset($_GET['id'])) {
		$ID = $_GET['id'];
	} else {
		$ID = "";
	}
			
	// create array variable to handle error
	$error = array();
			
	// create array variable to store data from database
	$data = array();
		
	// get data from reservation table
	$sql_query = "SELECT id, title, message, image, link FROM tbl_fcm_template WHERE id = ?";
		
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Bind your variables to replace the ?s
		$stmt->bind_param('s', $ID);
		// Execute query
		$stmt->execute();
		// store result 
		$stmt->store_result();
		$stmt->bind_result(
				$data['id'], 
				$data['title'],
				$data['message'],
				$data['image'],
				$data['link']
				);
		$stmt->fetch();
		$stmt->close();
	}
			
?>

<?php
  $setting_qry    = "SELECT * FROM tbl_config where id = '1'";
  $setting_result = mysqli_query($connect, $setting_qry);
  $settings_row   = mysqli_fetch_assoc($setting_result);

  $onesignal_app_id = $settings_row['onesignal_app_id']; 
  $onesignal_rest_api_key = $settings_row['onesignal_rest_api_key'];
  $protocol_type = $settings_row['protocol_type'];

  define("ONESIGNAL_APP_ID", $onesignal_app_id);
  define("ONESIGNAL_REST_KEY", $onesignal_rest_api_key);

  $cat_qry = "SELECT * FROM tbl_fcm_template ORDER BY message";
  $cat_result = mysqli_query($connect, $cat_qry); 
 

  if (isset($_POST['submit'])) {

        $cat_name = '';

	    if ($_POST['external_link'] != "") {
	    	$external_link = $_POST['external_link'];
	    } else {
	        $external_link = "no_url";
	    } 

        $big_image = $protocol_type.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/upload/notification/'.$data['image'];

        $content = array(
                         "en" => $_POST['message']                                                 
                         );

        $fields = array(
                        'app_id' => ONESIGNAL_APP_ID,
                        'included_segments' => array('All'),                                            
                        'data' => array("foo" => "bar","cat_id"=> "0","cat_name"=>$cat_name, "external_link"=>$external_link),
                        'headings'=> array("en" => $_POST['title']),
                        'contents' => $content,
                        'big_picture' => $big_image         
                        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.ONESIGNAL_REST_KEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);        
        
        $_SESSION['msg'] = "Congratulations, push notification sent...";
        header("Location:manage-notification.php");
        exit; 

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
          <li class="active">Send Notification</li>
        </ol>
        <!--breadcrum end-->
    
        <div class="section"> 

            <form id="validationForm" method="post" enctype="multipart/form-data">
            <div class="pmd-card pmd-z-depth">
                <div class="pmd-card-body">

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="lead">SEND NOTIFICATION</div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield">
                                <label for="title" class="control-label">
                                    Title *
                                </label>
                                <input type="text" name="title" id="title" class="form-control" value="<?php echo $data['title']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield">
                                <label for="message" class="control-label">
                                    Message *
                                </label>
                                <input type="text" name="message" id="message" class="form-control" value="<?php echo $data['message']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group pmd-textfield">
                                <label for="regular1" class="control-label">Big Image ( jpg / png) *</label>
                                <input type="file" name="category_image" id="category_image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/notification/<?php echo $data['image']; ?>" data-show-remove="false" disabled/>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield">
                                <label for="message" class="control-label">
                                    Url (Optional)
                                </label>
                                <input type="text" name="external_link" id="external_link" class="form-control" placeholder="http://www.your-url.com" value="<?php echo $data['link']; ?>">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" id="id" value="0" />
                    <input type="hidden" name="image" id="image" value="<?php echo $data['image']; ?>" />                    

                </div>

                <div class="pmd-card-actions">
                    <p align="right">
                    <button type="submit" class="btn pmd-ripple-effect btn-danger" name="submit">Send Now</button>
                    </p>
                </div>
            </div> <!-- section content end -->  
            </form>
        </div>
            
    </div><!-- tab end -->

</div><!--end content area -->

<?php include 'public/footer.php'; ?>