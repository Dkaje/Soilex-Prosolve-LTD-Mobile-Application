<?php  
        $limit = 5;
        $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
        $paginationStart = ($page - 1) * $limit;
        $next = $page +1;
        $prev = $page -1;
?>
<?php        
                 include_once('includes/config.php'); // write your db-connect.php to connect to database.
                $query1 = "SELECT * FROM tbl_customer";
                $result1 = mysqli_query($connect, $query1);
                $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                $total = $row1['email'];
                $totalpages = ceil($total / $limit) ;

                $query = "SELECT * FROM tbl_customer LIMIT $paginationStart,$limit";
                $result = mysqli_query($connect, $query);
                if ($result == FALSE) {
                    die(mysqli_error());
                    exit();
                }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .text-font{
            font-size: 35px;
            font-weight: bolder;
        }
        .height{
            height: 100vh   ;
        }
        .error{
                color: red;
                font-size: large;
            
            }
            .success{
                color: green;
                font-size: large;
          
            }
    </style>
       
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 bg-dark height">
                <p class="pt-5 pb-5 text-center">
                    <a href="admin-panel.php" class="text-decoration-none"><span class="text-light text-font">Admin</span></a>
                </p>
                <hr class="bg-light ">
                 <p class="pt-2 pb-2 text-center">
                    <a href="admin-profile.php" class="text-decoration-none"><span class="text-light">Profile</span></a>
                </p>
                <hr class="bg-light ">
                <p class="pt-2 pb-2 text-center">
                    <a href="categories.php" class="text-decoration-none"><span class="text-light">Categories</span></a>
                </p>
                <hr class="bg-light ">
                 <p class="pt-2 pb-2 text-center">
                    <a href="subcategories.php" class="text-decoration-none"><span class="text-light">Browse Categories</span></a>
                </p>
                <hr class="bg-light ">
                <p class="pt-2 pb-2 text-center">
                    <a href="products-add.php" class="text-decoration-none"><span class="text-light">Add Products</span></a>
                </p>
                <hr class="bg-light ">
                <p class="pt-2 pb-2 text-center">
                    <a href="products-display.php" class="text-decoration-none"><span class="text-light">View Products</span></a>
                </p>
                <hr class="bg-light ">
                <p class="pt-2 pb-2 text-center">
                    <a href="new-user-requests.php" class="text-decoration-none"><span class="text-light">New user requests</span></a>
                </p>
                <hr class="bg-light ">
                <p class="pt-2 pb-2 text-center">
                    <a href="view-users.php" class="text-decoration-none"><span class="text-light">View user</span></a>
                </p>                
                <hr class="bg-light ">
                <p class="pt-2 pb-2 text-center">
                    <a href="display-orders.php" class="text-decoration-none"><span class="text-light">View Orders</span></a>
                </p>
            </div>
            <div class="col-sm-10 bg-light">
               <div class="row">
                   <div class="col-sm-2">
                       <p class="text-center pt-5">
                                    <img class="rounded" src="<?php echo ("/test123/profile-pic/") . ($_SESSION['email']) . "display-picture.jpg"; ?>" width="150px" height="140px">
                                </p>
                   </div>
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
                                <?php $i=$paginationStart+1; while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ ?>
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
                        <?php 
                                include('allow.php');
                                
                        ?>
                        
                        <div class="container pt-5">
                            <div class="row">
                            <div class="col-sm-4">
                                 
                            </div>
                            <div class="col-sm-4">
                                <nav aria-label="...">
                                  <ul class="pagination">
                                    <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                        <a class="page-link"
                                            href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Previous</a>
                                    </li>
                                    
                                    <?php for($i = 1; $i <= $totalpages; $i++ ): ?>
                                    <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                                        <a class="page-link" href="new-user-requests.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                                    </li>
                                    <?php endfor; ?>
                                    
                                    <li class="page-item <?php if($page >= $totalpages) { echo 'disabled'; } ?>">
                                        <a class="page-link"
                                            href="<?php if($page >= $totalpages){ echo '#'; } else {echo "?page=". $next; } ?>">Next</a>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                            <div class="col-sm-4">
                            </div>
                            </div>
                        </div>
               
                        <p class="text-center"><span class="error"></span><span class="success"></span></p>
                
                    </div>
                </div>
            </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
      