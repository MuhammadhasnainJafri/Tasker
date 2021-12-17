
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
if ($user_role != 1) {
  header('Location: update-employee.php');
}

$admin_id = $_GET['admin_id'];

if(isset($_POST['update_current_employee'])){

    $obj_admin->update_user_data($_POST,$admin_id);
}

if(isset($_POST['btn_user_password'])){

    $obj_admin->update_user_password($_POST,$admin_id);
}



$sql = "SELECT * FROM tbl_admin WHERE user_id='$admin_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
        
$page_name="Admin";
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
                <h4>Edit Employee</h4>
                <p class="text-gray">Task Management System</p>
              </div>
            </div>


            <div class="grid">
                 
            <div class="col-lg-12">
                <div class="grid">
                 <h3 class="text-center bg-info p-2 text-light">EDIT EMPLOYEE</h3>
                  <div class="grid-body">
                    <div class="item-wrapper">
                      <div class="row mb-3">
                        <div class="col-md-8 mx-auto">
                        <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">

                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Fullname</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <input type="text" value="<?php echo $row['fullname']; ?>" placeholder="Enter Employee Name" name="em_fullname" list="expense" class="form-control input-custom" id="default" required>
                             </div>
                          </div>
                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">username</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <input type="text" value="<?php echo $row['username']; ?>" placeholder="Enter Employee Username" name="em_username" class="form-control input-custom" required>
                             </div>
                          </div>

                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Email</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <input type="email" value="<?php echo $row['email']; ?>" placeholder="Enter employee email" name="em_email" class="form-control input-custom" required>
                             </div>
                          </div>
                         
                          
                         
                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                             
                            </div>
                            <div class="col-md-9 mt-2 showcase_content_area">
                            <button type="submit" name="update_current_employee" class="btn btn-info">Update Now</button>
                             
                          </div>
                          </div>
                          
                                </form>


                                <form action="" method="POST">
                                <d  iv class="form-group row showcase_row_area m-3">
                            <div class="col-md-3 showcase_text_area">
                              
                            <label for="admin_password">New Password:</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <input type="text" name="employee_password" class="form-control input-custom" id="employee_password"  min="8" required>
                            
                            
                              <button type="submit" name="btn_user_password" class="btn btn-danger mt-3">Ok</button>
 </div>
                          </div>








                              
                         
</div>
                                
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                 
                </div>
           



            </div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true
  });

  flatpickr('#t_end_time', {
    enableTime: true
  });

</script>
        
      <!-- content viewport ends -->
        <?php  

        include('includes/footer.php');
        ?>
  </body>
</html>