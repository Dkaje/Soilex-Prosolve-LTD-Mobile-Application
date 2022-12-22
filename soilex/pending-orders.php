<?php
  include_once('includes/config.php');

$name = $_POST["username"];
$code = $_POST["code"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$address= $_POST["address"];
$shipping = $_POST["shipping"];
$date_time = $_POST["date_time"];
$order_list = $_POST["order_list"];
$order_total= $_POST["order_total"];
$comment = $_POST["comment"];
$status = $_POST["status"];
$player_id = $_POST["pid"];


$isValidEMail = filter_var($email , FILTER_VALIDATE_EMAIL);
if($connect){
$sqlcode = "SELECT * FROM tbl_order WHERE code LIKE '$code'";
            $code_query = mysqli_query($connect, $sqlcode);
  if(mysqli_num_rows($code_query) > 0){
 echo "Inserted";
  }
  else{
   
     $sql_register = "INSERT INTO tbl_order (`code`, `name`, `email`, `phone`, `address`, `shipping`, `date_time`,`order_list`, `order_total`, `comment`, `status`, `player_id`)
  VALUES ('$code','$name','$email','$phone','$address','$shipping','$date_time','$order_list','$order_total','$comment','$status','$player_id')";
if(mysqli_query($connect,$sql_register)){
echo "successfully";
}
else{
echo "Failed";
}
  }




}
else{
echo "Connection Error";
}
?>