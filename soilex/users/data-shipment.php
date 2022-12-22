<?php

$con = mysqli_connect('sql306.epizy.com', 'epiz_33000797', 'NQzgcQuTrS1u','epiz_33000797_ecommerce_android_app');

// get the post records
$name = $_POST['name'];
$user = $_POST['user'];
$email = $_POST['email'];
$password = $_POST['password'];
$status = $_POST['status'];


$sqlCheckEmail = "SELECT * FROM tbl_shipment WHERE email LIKE '$email'";
$email_query = mysqli_query($con, $sqlCheckEmail);
 if(mysqli_num_rows($email_query) > 0){
  echo "User  already used type another one";
 }
  else{
     $sql = "INSERT INTO tbl_shipment (`user`, `name`, `email`, `password`, `status`)
  VALUES ('$user','$name','$email','$password','$status')";


$rs = mysqli_query($con, $sql);

if($rs)
{
    echo " Records Inserted";
}
  }

?>