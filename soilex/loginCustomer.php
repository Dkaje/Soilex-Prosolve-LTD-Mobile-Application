<?php
 
  if($_SERVER['REQUEST_METHOD']=='POST'){

	include_once('includes/config.php');
 

 
 $email = $_POST['email'];
 $password = $_POST['psw'];




 $Sql_Query = "select * from tbl_customer where email = '$email' and status = '1'";
 
 $check = mysqli_fetch_array(mysqli_query($connect,$Sql_Query));

 
  if(isset($check)){

 
 echo "Login";
 }
 else{
 echo "Not approved yet  wait";
 }
 
 }else{
 echo "Check Again";
 }


?>


