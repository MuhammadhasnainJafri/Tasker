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


if(isset($_GET['delete_user'])){
  $action_id = $_GET['admin_id'];

  $task_sql = "DELETE FROM task_info WHERE t_user_id = $action_id";
  $delete_task = $obj_admin->db->prepare($task_sql);
  $delete_task->execute();

  $attendance_sql = "DELETE FROM attendance_info WHERE atn_user_id = $action_id";
  $delete_attendance = $obj_admin->db->prepare($attendance_sql);
  $delete_attendance->execute();
  
  $sql = "DELETE FROM tbl_admin WHERE user_id = :id";
  $sent_po = "users.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

$page_name="Admin";

if(isset($_POST['add_new_employee'])){
  $error = $obj_admin->add_new_user($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
  <?php  

  include('includes/head.php');
  ?>
  <body class="header-fixed">
    

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
 <!-- Modal content-->
 <div class="modal-content">
        <div class="modal-header">
         
          <h2 class="modal-title text-center">Add Employee</h2>
          <button type="button" class="close" data-dismiss="modal"><span class="d-1">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 col-sm-12 m-auto">
              <?php if(isset($error)){ ?>
                <h5 class="alert alert-danger"><?php echo $error; ?></h5>
                <?php } ?>
              <form role="form" action="" method="post" autocomplete="off">
                <div class="form-horizontal">

                  <div class="form-group">
                    <label class="control-label col-sm-4">Fullname</label>
                    <div class="col-12">
                      <input type="text" placeholder="Enter Employee Name" name="em_fullname" list="expense" class="form-control input-custom" id="default" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="control-label col-sm-4">Username</label>
                    <div class="col-12">
                      <input type="text" placeholder="Enter Employee username" name="em_username" class="form-control input-custom" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Email</label>
                    <div class="col-12">
                      <input type="email" placeholder="Enter Employee Email" name="em_email" class="form-control input-custom" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">password</label>
                    <div class="col-12">
                      <input type="password" placeholder="Enter Password here" name="password" class="form-control input-custom" required>
                    </div>
                  </div>
                  
                 
                  
                  <div class="form-group">
                    
                      <button type="submit" name="add_new_employee" class="btn btn-success-custom">Add Employee</button>
                    
                      <button type="submit" class="btn btn-danger-custom" data-dismiss="modal">Cancel</button>
                    
                  </div>
                  
                </div>
              </form> 
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>



<!--modal for employee add-->
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
                <h4>User Managment System</h4>
               
              </div>
            </div>
           
            <?php  
            if(isset($_SESSION['error'])){
              echo "<h3 class='h4 bg-danger text-white p-2'>{$_SESSION['error']}</h3>";
              unset($_SESSION['error']);
            }
            if(isset($_SESSION['error1'])){
              echo "<h3 class='h4 bg-danger text-white p-2'>{$_SESSION['error1']}</h3>";
              unset($_SESSION['error1']);
            }
            if(isset($_SESSION['error2'])){
              echo "<h3 class='h4 bg-danger text-white p-2'>{$_SESSION['error2']}</h3>";
              unset($_SESSION['error2']);
            }


?>
            <?php if(isset($error)){ ?>
          <script type="text/javascript">
            $('#myModal').modal('show');
          </script>
          <?php } ?>
            <?php if($user_role == 1){ ?>
                
                  <button class="btn btn-success btn-menu float-right m-3" data-toggle="modal" data-target="#myModal">Add New Employee</button>
                
              <?php } ?>

            <div class="grid">
                  <!-- bg-success bg-primary bg-info  -->
                  <div class="item-wrapper">
                    <div class="table-responsive">
                      <table class="table info-table">
                        <thead>
                          <tr>
                          <th class="font-weight-bold">Serial No.</th>
                  <th class="font-weight-bold">Fullname</th>
                  <th class="font-weight-bold">Email</th>
                  <th class="font-weight-bold">Username</th>
                  <th class="font-weight-bold">Temp Password</th>
                  <th class="font-weight-bold">Details</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 ORDER BY user_id DESC";
                $info = $obj_admin->manage_all_info($sql);
                $serial  = 1;
                $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7">No Data found</td></tr>';
                  }
                while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                <tr>
                  <td><?php echo $serial; $serial++; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $row['username']; ?></td>
                  <td><?php echo $row['temp_password']; ?></td>
                  
                  <td><a title="Update Employee" href="update-employee.php?admin_id=<?php echo $row['user_id']; ?>">
                  <span class="mdi mdi-lead-pencil d-inline text-dark h5"></span></a>&nbsp;&nbsp;<a title="Delete" href="?delete_user=delete_user&admin_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();"> <span class="mdi mdi-delete d-inline text-dark h5"></span></a></td>
                </tr>
                
              <?php  } ?>

                        </tbody>
                      </table>
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