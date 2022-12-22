<?php include_once('functions.php'); ?>

    <?php

        if (isset($_GET['id'])) {
            $ID = $_GET['id'];
        } else {
            $ID = "";
        }

        $category_data = array();

        $sql_query = "SELECT image FROM tbl_fcm_template WHERE id = ?";

        $stmt_category = $connect->stmt_init();
        if ($stmt_category->prepare($sql_query)) {
            // Bind your variables to replace the ?s
            $stmt_category->bind_param('s', $ID);
            // Execute query
            $stmt_category->execute();
            // store result
            $stmt_category->store_result();
            $stmt_category->bind_result($previous_category_image);
            $stmt_category->fetch();
            $stmt_category->close();
        }       
            
        if (isset($_POST['btnEdit'])) {

            $title = $_POST['title'];
            $message = $_POST['message'];
            $link = $_POST['link'];

            $menu_image = $_FILES['category_image']['name'];
            $image_error = $_FILES['category_image']['error'];
            $image_type = $_FILES['category_image']['type'];

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
            $extension = end(explode(".", $_FILES["category_image"]["name"]));

            if (!empty($menu_image)) {
                if (!(($image_type == "image/gif") ||
                        ($image_type == "image/jpeg") ||
                        ($image_type == "image/jpg") ||
                        ($image_type == "image/x-png") ||
                        ($image_type == "image/png") ||
                        ($image_type == "image/pjpeg")) &&
                    !(in_array($extension, $allowedExts))
                ) {

                    $error['category_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
                }
            }
                
            if (!empty($title) && !empty($message) && empty($error['category_image'])) {

            if (!empty($menu_image)) {

                // create random image file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
                $function = new functions;
                $category_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

                // delete previous image
                $delete = unlink('upload/notification/' . "$previous_category_image");

                // upload new image
                $upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/notification/' . $category_image);

                $sql_query = "UPDATE tbl_fcm_template SET title = ?, message = ?, image = ?, link = ? WHERE id = ?";

                $upload_image = $category_image;
                $stmt = $connect->stmt_init();
                if ($stmt->prepare($sql_query)) {
                    // Bind your variables to replace the ?s
                    $stmt->bind_param('sssss', $title, $message, $upload_image, $link, $ID);
                    // Execute query
                    $stmt->execute();
                    // store result
                    $update_result = $stmt->store_result();
                    $stmt->close();
                }

            } else {                
                    
                $sql_query = "UPDATE tbl_fcm_template SET title = ?, message = ?, link = ? WHERE id = ?";
                    
                $stmt = $connect->stmt_init();
                if($stmt->prepare($sql_query)) {    
                    // Bind your variables to replace the ?s
                    $stmt->bind_param('ssss', $title, $message, $link, $ID);
                    // Execute query
                    $stmt->execute();
                    // store result 
                    $update_result = $stmt->store_result();
                    $stmt->close();
                }
            
            }

                // check update result
                if ($update_result) {
                    //$error['update_notification'] = "<br><div class='alert alert-info'>Push Notification Template Successfully Updated...</div>";
                    $succes =<<<EOF
                    <script>
                    alert('Push Notification Template Successfully Updated...');
                    window.location = 'manage-notification.php';
                    </script>
EOF;

                    echo $succes;
                } else {
                    $error['update_notification'] = "<br><div class='alert alert-danger'>Update Failed</div>";
                }               

            }
                
        }
            
        // create array variable to store previous data
        $data = array();
        
        $sql_query = "SELECT id, title, message, image, link FROM tbl_fcm_template WHERE id = ?";
        
        $stmt = $connect->stmt_init();
        if($stmt->prepare($sql_query)) {    
            // Bind your variables to replace the ?s
            $stmt->bind_param('s', $ID);
            // Execute query
            $stmt->execute();
            // store result 
            $stmt->store_result();
            $stmt->bind_result($data['id'], 
                    $data['title'],
                    $data['message'],
                    $data['image'],
                    $data['link']
                    );
            $stmt->fetch();
            $stmt->close();
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
                                <input type="file" name="category_image" id="category_image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/notification/<?php echo $data['image']; ?>" data-show-remove="false"/>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield">
                                <label for="message" class="control-label">
                                    Url (Optional)
                                </label>
                                <input type="text" name="link" id="link" class="form-control" placeholder="http://www.your-url.com" value="<?php echo $data['link']; ?>">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="pmd-card-actions">
                    <p align="right">
                    <button type="submit" class="btn pmd-ripple-effect btn-danger" name="btnEdit">Submit</button>
                    </p>
                </div>
            </div> <!-- section content end -->  
            </form>
        </div>
            
    </div><!-- tab end -->

</div><!--end content area -->