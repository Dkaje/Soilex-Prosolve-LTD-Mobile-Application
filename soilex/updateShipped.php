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


// $isValidEMail = filter_var($email , FILTER_VALIDATE_EMAIL);
if($connect){

   if($status=='4'){
    $sql = "UPDATE tbl_order SET status='4' WHERE code LIKE '$code'";
  if ($connect->query($sql) === TRUE) {
  echo "Record updated successfully";
   } else {
  echo "Error updating record: " . $connect->error;
    }
  }

  if($status=='3'){
    $sql = "UPDATE tbl_order SET status='3' WHERE code LIKE '$code'";
  if ($connect->query($sql) === TRUE) {
  echo "Record updated successfully";
   } else {
  echo "Error updating record: " . $connect->error;
    }
  }
  if($status=='2'){
    $sql = "UPDATE tbl_order SET status='2' WHERE code LIKE '$code'";
  if ($connect->query($sql) === TRUE) {
  echo "Record updated successfully";
   } else {
  echo "Error updating record: " . $connect->error;
    }
  }
   if($status=='1'){
    $sql_register = "INSERT INTO tbl_order (`code`, `name`, `email`, `phone`, `address`, `date_time`, `order_list`, `status`) VALUES ('$code','$name','$email','$phone','$address','$date_time','$order_list','status')";
    //$sql = "UPDATE tbl_order SET status='3' WHERE code LIKE '$code'";
  if ($connect->query($sql) === TRUE) {
  echo "Record updated successfully";
   } else {
  echo "Error updating record: " . $connect->error;
    }
  }
  else{
    echo $status;
  }

}
else{
echo "Connection Error";
}
?>