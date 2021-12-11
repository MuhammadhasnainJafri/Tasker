<?php
require 'includes/auth.php'; 
// admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// check admin
$user_role = $_SESSION['user_role'];




?>
 <?php 




if(isset($_GET['status'])){
    $status= $_GET['status'];


                if($user_role == 1){
                  $sql = "SELECT a.*, b.fullname 
                        FROM task_info a
                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id) where `status`='$status'
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
                }else {
                  echo "style='background:#dc3545 !important'";
                }
                
                
                ?>
                
                >
                 
                  <td><?php echo $row['t_title']; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td><?php echo $row['t_start_time']; ?></td>
                  <td><?php echo $row['t_end_time']; ?></td>
                  <td>
                    <?php  if($row['status'] == 1){
                        echo "In Progress";
                    }elseif($row['status'] == 2){
                       echo "Completed ";
                    }else{
                      echo "Incomplete";
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
                <?php } }?>

                    
