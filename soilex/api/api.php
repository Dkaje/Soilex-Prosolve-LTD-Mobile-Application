<?php

	include_once ('../includes/config.php');
 	$connect->set_charset('utf8');

    $sql_query    	= "SELECT * FROM tbl_admin ORDER BY id DESC LIMIT 1";
    $user_result	= mysqli_query($connect, $sql_query);
    $user_row	    = mysqli_fetch_assoc($user_result);
    $admin_email  	= $user_row['email'];	
	
	if (isset($_GET['category_id'])) {		
		$query = "SELECT p.product_id, p.product_name, p.category_id, n.category_name, p.product_price, p.product_status, p.product_image, p.product_description, p.product_quantity, c.currency_id, c.tax, o.currency_code, o.currency_name FROM tbl_category n, tbl_product p, tbl_config c, tbl_currency o WHERE c.currency_id = o.currency_id AND c.id = 1 AND n.category_id = p.category_id AND n.category_id ='".$_GET['category_id']."' ORDER BY p.product_id DESC";			
		$resouter = mysqli_query($connect, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set[] = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));		
			
	} else if (isset($_GET['get_recent'])) {

		$query = "SELECT p.product_id, p.product_name, p.category_id, n.category_name, p.product_price, p.product_status, p.product_image, p.product_description, p.product_quantity, c.currency_id, c.tax, o.currency_code, o.currency_name FROM tbl_category n, tbl_product p, tbl_config c, tbl_currency o WHERE n.category_id = p.category_id AND c.currency_id = o.currency_id AND c.id = 1 ORDER BY p.product_id DESC";
		$resouter = mysqli_query($connect, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set[] = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));
			
	} else if (isset($_GET['get_category'])) {
		$query = "SELECT DISTINCT c.category_id, c.category_name, c.category_image, COUNT(DISTINCT p.product_id) as product_count FROM tbl_category c LEFT JOIN tbl_product p ON c.category_id = p.category_id GROUP BY c.category_id ORDER BY c.category_id DESC";			
		$resouter = mysqli_query($connect, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set[] = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));

	} else if (isset($_GET['get_tax_currency'])) {
		$query = "SELECT c.tax, o.currency_code FROM tbl_config c, tbl_currency o WHERE c.currency_id = o.currency_id AND c.id = 1";			
		$resouter = mysqli_query($connect, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));

	} else if (isset($_GET['post_order'])) {

		$code 		 = $_POST['code'];
		$name 		 = $_POST['name'];
		$email 		 = $_POST['email'];
		$phone 		 = $_POST['phone'];
		$address 	 = $_POST['address'];
		$shipping 	 = $_POST['shipping'];
		$order_list  = $_POST['order_list'];
		$order_total = $_POST['order_total'];
		$comment 	 = $_POST['comment'];
		$player_id 	 = $_POST['player_id'];
		$date 		 = $_POST['date'];
		$server_url  = $_POST['server_url'];
		 
		$query = "INSERT INTO tbl_order (code, name, email, phone, address, shipping, order_list, order_total, comment, player_id) VALUES ('$code', '$name', '$email', '$phone', '$address', '$shipping', '$order_list', '$order_total', '$comment', '$player_id')";
		 
		if (mysqli_query($connect, $query)) {
			include_once ('php-mail.php');
			echo 'Data Inserted Successfully';
		} else {
			echo 'Try Again';
		}
		mysqli_close($connect);		

	} else if (isset($_GET['get_shipping'])) {

		$query = "SELECT * FROM tbl_shipping ORDER BY shipping_id ASC";
		$resouter = mysqli_query($connect, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set['result'][] = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));
			
	} else if (isset($_GET['get_help'])) {

		$query = "SELECT * FROM tbl_help ORDER BY id DESC";
		$resouter = mysqli_query($connect, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set[] = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));
			
	} else if (isset($_GET['product_id'])) {
		$query = "SELECT p.product_id, p.product_name, p.category_id, n.category_name, p.product_price, p.product_status, p.product_image, p.product_description, p.product_quantity, c.currency_id, c.tax, o.currency_code, o.currency_name FROM tbl_category n, tbl_product p, tbl_config c, tbl_currency o WHERE n.category_id = p.category_id AND c.currency_id = o.currency_id AND c.id = 1 AND p.product_id ='".$_GET['product_id']."'";
		$resouter = mysqli_query($connect, $query);

		$set = array();
	    $total_records = mysqli_num_rows($resouter);
	    if($total_records >= 1) {
	      	while ($link = mysqli_fetch_array($resouter, MYSQLI_ASSOC)){
	        $set = $link;
	      }
	    }

	    header('Content-Type: application/json; charset=utf-8');
	    echo $val = str_replace('\\/', '/', json_encode($set));

	} else {
		header('Content-Type: application/json; charset=utf-8');
		echo "no method found!";
	}
	 
?>