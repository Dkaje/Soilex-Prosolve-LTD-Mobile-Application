<?php
  // use PHPMailerPHPMailerPHPMailer;
  // use PHPMailerPHPMailerException;
 use PHPMailer\PHPMailer\PHPMailer;
  require 'vendor/phpmailer/phpmailer/src/Exception.php';
  require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require_once 'vendor/autoload.php';

  include_once('includes/config.php');
  // Include autoload.php file
  //require 'vendor/autoload.php';
  // Create object of PHPMailer class
//new PHPMailer\PHPMailer\PHPMailer();
  $mail = new PHPMailer(true);

  $output = '';
 

    $email = $_POST['email'];
  
    $choice = $_POST['choice'];




  if($choice=="admin"){
            $sqlCheckEmail = "SELECT * FROM tbl_admin WHERE email LIKE '$email'";
            $email_query = mysqli_query($connect, $sqlCheckEmail);
if(mysqli_num_rows($email_query) > 0){

   try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      // Gmail ID which you want to use as SMTP server
      $mail->Username = 'markellytech@gmail.com';
      // Gmail Password
      $mail->Password = 'cfqppmrmletkoaux';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;
 
      // Email ID from which you want to send the email
      $mail->setFrom('markellytech@gmail.com');
      // Recipient Email ID where you want to receive emails
      $mail->addAddress($email);
      $length = 8;
     $chars = '23456789bcdfhkmnprstvzBCDFHJKLMNPRSTVZ';
      $shuffled = str_shuffle($chars);
     $result = mb_substr($shuffled, 0, $length);





 
      $mail->isHTML(true);
      $mail->Subject = 'Soilex Admin Reset Password';
      $mail->Body = "<h3><br>Email : $email <br>your New Admin Password is  :  $result</h3><br><br>Dont reply";

      $mail->send();
  
           $sql_register ="UPDATE tbl_admin SET password='$result' WHERE email='$email'";
if(mysqli_query($connect,$sql_register)){
echo "updated successfully";
}else{
echo "Failed to register you account";
}
     // echo "successfully";
    } catch (Exception $e) {
      $output = '<div class="alert alert-danger">
                  <h5>' . $e->getMessage() . '</h5>
                </div>';
    }

}
else{
  echo "Admin Email does not exist";
}
        }




?>