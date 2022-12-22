<?php 

	// be careful when you change the email subject and content, do not change or remove the variables, just change the text content
	// inaccuracies in changing or removing variables can cause errors

	// email order notification for administrator
	$to = $admin_email;
	$subject = "[E-Commerce Android App] Order Information From : ".$name. " - Purchase Code : ".$code. " ";
	$message = "Hello Admin, <br><br>This is an email notification that there is an order with the details below : 
					<br><br>Name : ".$name. "
					<br>Code : ".$code. "
					<br>Email : ".$email. "
					<br>Phone : ".$phone. "
					<br>Address : ".$address. "
					<br>Shipping : ".$shipping. "
					<br>Date : ".$date. "
					<br>Order List : <br>".str_replace(',', '<br>', $order_list). "
					
					<br><br>Please login to your admin panel to see and confirm the order :
					<br><a href=".$server_url.">click here</a>.

					<br><br>© 2019 E-Commerce Android App. All Rights Reserved. 
					";

	// email invoice detail for buyer
	$to2 = $email;
	$subject2 = "[E-Commerce Android App] Your Invoice Detail : ".$name. " - Purchase Code : ".$code. " ";
	$message2 = "Hi ".$name.", <br><br>This is a notification that an invoice has been created from your order with details below : : 
					<br><br>Name : ".$name. "
					<br>Code : ".$code. "
					<br>Email : ".$email. "
					<br>Phone : ".$phone. "
					<br>Address : ".$address. "
					<br>Shipping : ".$shipping. "
					<br>Date : ".$date. "
					<br>Order List : <br>".str_replace(',', '<br>', $order_list). "
					
					<br><br>Please make payment soon so that your order will be processed.
					
					<br><br>All Payment can be made by transfer to : 
					<br>Bank BCA: 123456789
					<br>Bank BNI : 123456789
					<br>Bank BRI : 123456789
					<br>Bank MANDIRI : 123456789
					<br>PayPal : help.solodroid@gmail.com

					<br><br>After making a payment, please confirm your payment via the email below by attaching your proof of payment :
					<br>".$admin_email. "

					<br><br>© 2019 E-Commerce Android App. All Rights Reserved. 
					";

	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: E-Commerce Android App <don-not-reply@solodroid.co.id>' . "\r\n";

	//send email to administrator
	@mail($to, $subject, $message ,$headers);

	//send email to buyer
	@mail($to2, $subject2, $message2 ,$headers);

?>