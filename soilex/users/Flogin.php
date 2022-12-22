<?php
 
  if($_SERVER['REQUEST_METHOD']=='POST'){
 $connect = mysqli_connect('sql306.epizy.com', 'epiz_33000797', 'NQzgcQuTrS1u','epiz_33000797_ecommerce_android_app');
 

 
 $email = $_POST['email'];
 $password = $_POST['psw'];




 $Sql_Query = "select * from tbl_finance where email = '$email' and password = '$password' and status='1'";
 
 $check = mysqli_fetch_array(mysqli_query($connect,$Sql_Query));

 
  if(isset($check)){

 
 echo "Login";
 }
 else{
 echo "Not approved yet!";
 }
 
 }else{
 echo "Check Again";
 }


?>