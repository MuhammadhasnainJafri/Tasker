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

$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
                <h4>Update  Task Status</h4>
                <p class="text-gray">Task Management System</p>
              </div>
            </div>


            <div class="grid">
                 
            <div class="col-lg-12">
                <div class="grid">
                 <h3 class="text-center bg-info p-2 text-light">Update Task Status</h3>
                  <div class="grid-body">
                    <div class="item-wrapper">
                      <div class="row mb-3">
                        <div class="col-md-8 mx-auto">
                        <form class="form-horizontal" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                      
                          <?php 
                          $user_id=$row['t_user_id'];
                            $sql="SELECT * from record where user_id=$user_id and  task_id=$task_id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              // output data of each row
                              while($record = $result->fetch_assoc()) {
                               ?>
                                 <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Status</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <select class="form-control" name="status" id="status" <?php 
                            if($row['status'] == 2){echo "disabled";} ?>>
			                      	<option value="0" <?php if($row['status'] == 0){ ?>selected <?php } ?>>Incomplete</option>
			                      	<option value="1" <?php if($row['status'] == 1){ ?>selected <?php } ?>>In Progress</option>
			                      	<option value="2" <?php if($row['status'] == 2){ ?>selected <?php } ?>>Completed</option>
			                      </select>
                          </div>
                          <input type="number" name="record_id" value="<?php echo $record['id'];  ?>" hidden>
                          </div>
                               <div class="form-group row showcase_row_area" >
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Any Description</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <textarea class="form-control" name="task_complete_description" >
                            <?php  
                              echo $record['description'];
                            ?>
                            </textarea>
                            
                          </div>
                          </div>
                          <div class="form-group row showcase_row_area" >
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Picture of work</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                              <img src="uploads/<?php  echo $record['picture'] ?>" alt="picture here" width="100" style="display:block;">
                              <?php if($row['status'] != 2){  ?>
                            <input type="file" name="image" id="file" accept="image/*" required style="margin-top:10px">
                          <?php } ?> 
                            
                          </div>
                          </div>


<?php
                              }
                            } else {?>
                              <div id="hide" >
                              <div class="form-group row showcase_row_area" >
                                <div class="col-md-3 showcase_text_area">
                                  <label for="inputType1">Any Description</label>
                                </div>
                                <div class="col-md-9 showcase_content_area">
                                <textarea class="form-control" name="task_complete_description" required ></textarea>
                                
                              </div>
                              </div>
                              <div class="form-group row showcase_row_area" >
                                <div class="col-md-3 showcase_text_area">
                                  <label for="inputType1">Picture of work</label>
                                </div>
                                <div class="col-md-9 showcase_content_area">
                                <input type="file" name="image" id="file" accept="image/*" required>
                                
                              </div>
                              </div>
                              
                                            </div>
                                          
                           <?php }
                          ?>
                      <?php  
                      if($row['status'] != 2){?>
                        <div class="form-group row showcase_row_area" >
                            <div class="col-md-3 showcase_text_area">
                             
                            </div>
                            <div class="col-md-9 mt-2 showcase_content_area">
                            <button type="submit" name="update_task_info" class="btn btn-success">Update Now</button>

                          </div>
                          </div>




                      <?php }



?>
                                       

<br><br><br>
<h3 class="h1 text-center">Task Detail</h3>

                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Task Title</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                              <input type="text" class="form-control" name="task_title"  value="<?php echo $row['t_title']; ?>" <?php if($user_role != 1){ ?> readonly <?php } ?> >
                            </div>
                          </div>
                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Task Description</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <textarea class="form-control" name="task_description" id="inputType9"  <?php if($user_role != 1){ ?> readonly <?php } ?>>
                            <?php echo $row['t_description']; ?>
                            </textarea>
                            </div>
                          </div>
                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Start Time</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                              <input type="text" class="form-control" name="t_start_time" id="t_start_time"  value="<?php echo $row['t_start_time'];  ?>"  <?php if($user_role != 1){ ?> readonly <?php } ?> >
                            </div>
                          </div>
                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">End Time</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                              <input type="text" name="t_end_time" id="t_end_time" class="form-control" value="<?php echo $row['t_end_time']; ?>"  <?php if($user_role != 1){ ?> readonly <?php } ?> >
                            </div>
                          </div>
                          <div class="form-group row showcase_row_area">
                            <div class="col-md-3 showcase_text_area">
                              <label for="inputType1">Assign To</label>
                            </div>
                            <div class="col-md-9 showcase_content_area">
                            <?php 
			                        $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2 and user_id= {$row['t_user_id']}";
			                        $info = $obj_admin->manage_all_info($sql);   
			                      ?>
			                      <select class="form-control" name="assign_to" id="aassign_to" <?php if($user_role != 1){ ?> disabled="true" <?php } ?>>
			                        <option value="">Select</option>

			                        <?php while($rows = $info->fetch(PDO::FETCH_ASSOC)){
                                        
                                        
                                        
                                        ?>
			                        <option value="<?php echo $rows['user_id']; ?>" <?php
			                        	if($rows['user_id'] == $row['t_user_id']){
			                         ?> selected <?php } ?>><?php echo $rows['fullname']; ?></option>
			                        <?php } ?>
			                      </select>
                            </div>
                          </div>
                         


                         
                          
                                </form>
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