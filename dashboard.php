<?php

require 'includes/auth.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}
// check admin 
$user_role = $_SESSION['user_role'];
if($user_role != 1){
  header('Location: task.php');
}

$countresult = $obj_admin->countDash($_POST);

$page_name="Dashboard";




?>
<!DOCTYPE html>
<html lang="en">
  <?php  

  include('includes/head.php');
  ?>
  <body class="header-fixed">
  <?php  
 include('includes/header.php');

  ?>
    <div class="page-body">
      <!-- partial:partials/_sidebar.html -->
     <?php
include("includes/sidebar.php");

?>
      <!-- partial -->
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="content-viewport">
            <div class="row">
              <div class="col-12 py-5">
                <h4>Dashboard</h4>
                <p class="text-gray">Welcome , <?php   echo $_SESSION['name'];?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                     <h3>Task In Progress </h3>
                     
                    </div>
                    <p class="text-black text-center"><h2><?php echo $countresult[1]?></h2></p>
                   
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                     <h3>Task Completed</h3>
                    </div>
                   <h1><?php echo $countresult[2]?></h1>
                   
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                     <h3>Task Incomplete</h3>
                    </div>
                  <h2><?php echo $countresult[0]?></h2>
                    
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between">
                     <h3>Number of user</h3>
                    </div>
                   <h3><?php echo $countresult[3] ?></h3>
                  </div>
                </div>
              </div>
           



            </div>
          </div>
        </div>
        <!-- content viewport ends -->
        <?php  

        include('includes/footer.php');
        ?>
  </body>
</html>