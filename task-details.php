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

$task_id = $_GET['task_id'];



if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST,$task_id, $user_role);
}

$page_name="Edit Task";

$sql = "SELECT a.*, b.fullname 
FROM task_info a
LEFT JOIN tbl_admin b ON(a.t_user_id = b.user_id)
WHERE task_id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
$host_name='localhost';
$user_name='root';
$password='';
$db_name='etmsh';
$conn = new mysqli($host_name, $user_name, $password, $db_name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
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
                <p class="text-gray">Welcome aboard, Name</p>
              </div>
            </div>
             

            <div class="table-responsive">
				                  <table class="table table-bordered table-single-product">
				                    <tbody>
				                      <tr>
				                        <td>Task Title</td><td><?php echo $row['t_title']; ?></td>
				                      </tr>
				                      <tr>
				                        <td>Description</td><td><?php echo $row['t_description']; ?></td>
				                      </tr>
				                      <tr>
				                        <td>Start Time</td><td><?php echo $row['t_start_time']; ?></td>
				                      </tr>
				                      <tr>
				                        <td>End Time</td><td><?php echo $row['t_end_time']; ?></td>
				                      </tr>
				                      <tr>
				                        <td>Assign To</td><td><?php echo $row['fullname']; ?></td>
				                      </tr>
				                      <tr>
				                        <td>Status</td><td><?php  if($row['status'] == 1){
											                        echo "In Progress";
											                    }elseif($row['status'] == 2){
											                       echo "Completed";
											                    }else{
											                      echo "Incomplete";
											                    } ?></td>
				                      </tr>
                                  <?php
                                  $user_id=$row['t_user_id'];
                                  $sql="SELECT * from record where user_id=$user_id and  task_id=$task_id";
                                  $result = $conn->query($sql);
                                  if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($record = $result->fetch_assoc()) {
                                     ?>
                                      
                               <tr>
                                    <td>Any Description</td>
                                  <td>
                                  
                                  <?php  
                                    echo $record['description'];
                                  ?>
                                  </td>
                                  </tr>
                                  <tr>
                                    <td>Work Image</td>
                                  <td>
                                  
                                  <img src="uploads/<?php  echo $record['picture'] ?>" alt="picture here" width="100" style="display:block;">
                             
                                  </td>
                                  </tr>
                                
                                   <?php }}

?>
                               
				                    </tbody>
				                  </table>
				                </div>

                        <a title="Update Task"  href="edit-task.php?task_id=<?php echo $_GET['task_id'];?>" class="btn btn-success-custom btn-lg mt-3 float-right ml-3 bg-info">
                                   Update Task </a>


                                <a   href="task.php" class="btn btn-success-custom btn-lg mt-3 float-right">
                                   Go Back </a>
                                   









          </div>
        </div>
        <!-- content viewport ends -->
        <?php  

        include('includes/footer.php');
        ?>
  </body>
</html>