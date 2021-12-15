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


if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}

$page_name="Task_Info";
// include("include/sidebar.php");
// include('ems_header.php');


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

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog add-category-modal">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h2 class="modal-title text-center">Assign New Task</h2>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
        
            <div class="col-md-12 col-sm-12 m-auto">
            <form role="form" action="" method="post" autocomplete="off">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-5">Task Title</label>
                  <div class="col-12">
                    <input type="text" placeholder="Task Title" id="task_title" name="task_title" list="expense" class="form-control" id="default" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Task Description</label>
                  <div class="col-12">
                    <textarea name="task_description" id="task_description" placeholder="Text Deskcription" class="form-control" rows="5" cols="5"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Start Time</label>
                  <div class="col-12">
                    <input type="text" name="t_start_time" id="t_start_time" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">End Time</label>
                  <div class="col-12">
                    <input type="text" name="t_end_time" id="t_end_time" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Address to work</label>
                  <div class="col-12">
                    <input type="text" name="address"  class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-5">Assign To</label>
                  <div class="col-12">
                    <?php 
                      $sql = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                      $info = $obj_admin->manage_all_info($sql);   
                    ?>
                    <select class="form-control" name="assign_to" id="aassign_to" onfocus='this.size=7;' onblur='this.size=1;' onchange='this.size=1; this.blur();' required>
                      <option value="">Select Employee...</option>

                      <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                      <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                 
                </div>
                <div class="form-group">
                </div>
                <div class="form-group">
                  
                    <button type="submit" name="add_task_post" class="btn btn-success-custom">Assign Task</button>
                  
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
<!-- ========================================== -->

<!---Modal Call using the class--->

<!---Modal--->
<div class="modal fade user-registration" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Filter Task</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
  <h5>Search task of specific date</h5>
  <hr>
  <div class="row">
  <div class="input-group col-6">
    <div class="input-group-prepend">
      <div class="input-group-text" id="btnGroupAddon">
      <span class='mdi mdi-calendar  d-inline' ></span>
      </div>
    </div>
    <input type="text"  id="d1" class="form-control date" style="height:100%" value="2021-12-11" aria-label="Input group example" aria-describedby="btnGroupAddon">
  </div>
  <button class="btn btn-info" onclick="gettask(document.getElementById('d1'))">></button>
   
  </div>
<!--
<h5 class="h5 hr" style=" border-bottom: 3px solid darken('#165578', 10);">Search task of between date</h5>
  <hr>
   <div class="input-group">
  
    <input type="text" id="d2"  class="form-control datetime"  value="2021-12-11" aria-label="Input group example" aria-describedby="btnGroupAddon">
 
   -
    <input type="text" id="d3" class="form-control datetime"  value="2021-12-11" aria-label="Input group example" aria-describedby="btnGroupAddon">
  
  <button class="btn btn-info" id="date_task" onclick="gettaskbetween(document.getElementById('d2'),document.getElementById('d3'))" >></button>
   
  </div> -->
  <div class="btn-group mt-4">
  <button class="btn btn-primary ml-3" onclick="statusresult(2)">Completed task</button>
  <button class="btn btn-danger ml-3" onclick="statusresult(0)">Incomplete task</button>
  <button class="btn btn-warning ml-3" onclick="statusresult(1)">Progress task</button>
  </div>


</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-success">Submit</button>
</div>
</div>
</div>
</div>

<!-- =============================================  -->




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
                <h4>Task Managment System</h4>
              
              </div>
            </div>
            <?php if($user_role == 1){ ?>
  
<button class="btn btn-warning btn-menu m-3 float-left" data-toggle="modal" data-target=".user-registration">Filter</button>

                  <button class="btn btn-warning btn-menu m-3 float-right" data-toggle="modal" data-target="#myModal">Assign New Task</button>
                
              <?php } ?>

            <div class="grid">
                  <!-- bg-success bg-primary bg-info  -->
                  <div class="item-wrapper">
                    <div class="table-responsive">
                      <table class="table info-table">
                        <thead>
                          <tr>
                            <th>Task Title</th>
                            <th>Assign to</th>
                            <th>Start time</th>
                            <th>End time</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                         
                          <?php 
                if($user_role == 1){
                  $sql = "SELECT a.*, b.fullname 
                        FROM task_info a
                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                        ORDER BY a.t_end_time DESC";
                }else{
                  $sql = "SELECT a.*, b.fullname 
                  FROM task_info a
                  INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                  WHERE a.t_user_id = $user_id and a.status != 2 
                  ORDER BY a.t_end_time DESC";
                } 
                
                  $info = $obj_admin->manage_all_info($sql);
                  $serial  = 1;
                  $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7">No Data found</td></tr>';
                  }
                      while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                <tr class="tr"
                <?php  if($row['status'] == 1){
                  echo "style='background:#ffc107 !important' ";
                }else if($row['status'] == 2){
                  echo "style='background:#28a745 !important'";
                }else if($row['status']==0){
                  echo "style='background:#dc3545 !important;'";
                }else if($row['status'] == 3){
                  echo "style='color: #004085;
                  background-color: darkturquoise;
                  border-color: darkturquoise;'";
                }
                
                
                ?>
                
                >
                 
                  <td><?php echo substr($row['t_title'],0,30); ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td><?php echo $row['t_start_time']; ?></td>
                  <td><?php echo $row['t_end_time']; ?></td>
                  <td>
                    <?php  if($row['status'] == 1){
                        echo "In Progress";
                    }elseif($row['status'] == 2){
                       echo "Completed ";
                    }else if($row['status'] == 0){
                      echo "Incomplete";
                    }else if($row['status'] == 3){
                      echo "Close";
                    } ?>
                    
                  </td>
  
                 <td>
                 
                  <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>">
                <span class="mdi mdi-folder d-inline text-light h5"></span>
                  <?php if($user_role == 1){ ?>
                    <a title="Update Task"  href="edit-task.php?task_id=<?php echo $row['task_id'];?>">
                  <span class="mdi mdi-lead-pencil d-inline text-light h5"></span>
               
                </a>&nbsp;&nbsp;
                  <a title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick=" return check_delete();">
                  <span class="mdi mdi-delete d-inline text-light h5"></span>
                </a></td>
                <?php }else{
                  echo "<a  href='empupdate.php?task_id={$row['task_id']}'>
                  <span class='mdi mdi-check-circle  d-inline text-light h5' style='color:#4CCEAC !important'></span>
               
                </a>&nbsp;&nbsp";
                } ?>
                </tr>
                <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
           



            </div>
          </div>

<script>
  
  function statusresult(d){
    
    $.ajax({url: "get_by_status.php?status="+d, success: function(result){
   $('#tbody').html(result);
   $('#close').click();
  }});
  }
  function gettask(date){
    // get_specific_date.php
    $.ajax({url: "get_specific_date.php?date="+date.value, success: function(result){
   $('#tbody').html(result);
   $('#close').click();
  }});
  }
  // function gettaskbetween(date1,date2){
  //   // get_specific_date.php
  //   $.ajax({url: "get_specific_date.php?date1="+date1.value+"&date2="+date2.value, success: function(result){
  //  $('#tbody').html(result);
  //  $('#close').click();
  // }});
  // }

  

  
</script>
        
          <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true,
    time_24hr: true,
    defaultDate: "13:45",
    allowInput: true,
    
  });
  flatpickr('.date', {
    enableTime: false,
    
    allowInput: true,
  });
  flatpickr('.datetime', {
    enableTime: true,
    time_24hr: true,
    defaultDate: "13:45",
    allowInput: true,
  });
  flatpickr('#t_end_time', {
    enableTime: true,
    time_24hr: true,
    defaultDate: "13:45",
    allowInput: true,
   
  });

</script>
      <!-- content viewport ends -->
        <?php  

        include('includes/footer.php');
        ?>
  </body>
  
  <script>
    function updatestatus(){
    var dt = new Date();
    var date=dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
    date=date.trim();
    $.ajax({url: "update-status.php?date="+date, success: function(result){
   
   
  }});
  }
    updatestatus();
    </script>

</html>