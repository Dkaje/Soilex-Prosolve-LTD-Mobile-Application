<?php
  include_once('includes/config.php');

$category = $_POST["category"];
$description = $_POST["description"];
$name = $_POST["name"];
$price = $_POST["price"];

$status= $_POST["status"];




if($connect){
  if($status==1){
    $qprice = $_POST["qprice"];

 $sql_register = "INSERT INTO tbl_supply (`category`, `description`, `name`, `price`,`qprice`,  `status`)
  VALUES ('$category','$description','$name','$price','$qprice','$status')";
if(mysqli_query($connect,$sql_register)){
echo "successfully";
}
else{
echo "Failed";
}
}

else{
   $sql_register = "INSERT INTO tbl_supply (`category`, `description`, `name`, `price`, `status`)
  VALUES ('$category','$description','$name','$price','$status')";
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