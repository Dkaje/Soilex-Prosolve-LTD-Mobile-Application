

<?php include 'public/menubar.php';



$conn=mysqli_connect("localhost","root","","adminmuseum");
$tebo="SELECT * FROM `customers` WHERE status=''";
$qry=mysqli_query($conn,$tebo);

?>
<div>
<h1>Customer pending</h1>

<table class="table table-bordered" id="tabledata" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th >Nos</th>
      <th>First name</th>
        <th>Second name</th>
      <th >email</th>
      <th>password</th>
      <th >phone</th>
      <th>Gender</th>
          <th >Reject</th>
      <th>Aprove</th>
   
   
    </tr>
  </thead>
 
  
  
   <tbody></br></br>
   <?php
              if(mysqli_num_rows($qry) > 0){


              while($row = mysqli_fetch_assoc($qry)){

                ?>
               
                <tr>
                </td>
              
                </td>

                
                <td> <?php          
                

                 echo $row['id'] ;
                 ?>
                 </td>
                 <td>
              <?php
            echo $row['username'] ;
            ?>
            </td>
               <td>
              <?php
            echo $row['sname'] ;
            ?>
            </td>
            
            <td>
              <?php
            echo $row['email'] ;
            ?>
            </td>
            
            <td>
              <?php
            echo $row['password'] ;
            ?>
            </td>
            <td>
              <?php
            echo $row['phone'] ;
            ?>
          </td>
          <td>
              <?php
            echo $row['gender'] ;
            ?>
          </td>
           

            </tr>           

<?php }
            }
            ?>
           
 

            
    </tbody>
  
    
</table>
<div>
</div>


<?php

include 'public/menubar.php';
include "includes/scripts.php"


?>
