
<?php        
                  include_once('includes/config.php'); 
        ?>
<!DOCTYPE html>
<html lang="en">

<body>
    
            <div class="col-sm-10 bg-light">
               <div class="row">
                  
                   <div class="col-sm-8">
                       <h1 class="text-center pt-4 pb-5"><strong>New user requests</strong></h1>
                       <hr class="w-25 mx-auto">
                   </div>
                   <div class="col-sm-2">
                       <p class="pt-5">
                            <a href="logout.php" class="btn btn-outline-primary">Logout</a>
                       </p>
                   </div>
               </div>
               <div class="container-fluid pt-5 pb-5 bg-light">
                    <div class="container width ">
                        <hr class="border-bottom bg-success w-50 mx-auto">
                        <div class="table table-responsive">
                            <table class="table table-striped w-100 table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                      <th class="text-left">Sl No.</th>
                                      <th class="text-left">First Name</th>
                                      <th class="text-left">Last Name</th>
                                      <th class="text-left">Email</th>
                                      <th class="text-left">Mobile</th>
                                      <th class="text-left">Address</th>
                                      <th class="text-left">
                                          <form action="search.php"  method="post">
                                              <input type="email" class="form-control" placeholder="Email to search" name="email">
                                      </th>
                                      <th>
                                          <input type="submit" class="form-control btn-btn-primary" value="Search">
                                          </form>
                                      </th>
                                    </tr>
                                </thead>
                                <tbody>
                               
                                <tr>
                                  <td><?php echo $i++; ?></td>
                                  <td><?php echo($row['fname']); ?></td>
                                  <td><?php echo($row['lname']); ?></td>
                                  <td><?php echo($row['email']); ?></td>
                                  <td><?php echo($row['mobile']); ?></td>
                                  <td><?php echo($row['address']); ?></td>
                                  <td>
                                     <form action="reject.php" method="post">
                                          <input type="hidden" name ="email" value="<?php echo($row['email']); ?>">
                                      <?php echo ("<button type='submit' name='reject' class='form-control' >Reject</button>"); ?>
                                     </form>
                                  </td>
                                  <td>
                                      <form action="" method="post">
                                          <input type="hidden" name ="email" value="<?php echo($row['email']); ?>">
                                      <?php echo ("<button type='submit' name='allow' class='form-control'>Allow</button>");?>
                                      </form>
                                  </td>
                                  
                                </tr>
                                <?php 
                                 } ?>
                                
                              </tbody>
                            </table> 
                        </div> 
                      
                        
                        
               
                        <p class="text-center"><span class="error"></span><span class="success"></span></p>
                
                    </div>
                </div>
            </div>
            </div>
        </div>
       </script>
</body>
</html>
                            
