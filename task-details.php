<?php

require 'includes/auth.php'; // admin authentication check 
$coordinate="";
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
<style>
   /* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: auto; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  max-height:80vh;
}



/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
} 
</style>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">
  
  <!-- map start at here  -->
   <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
integrity=
"sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin="" />
    <!-- map ends at here  -->

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>


 
      <!-- partial -->
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="content-viewport">
            <div class="row">
            <div class="col-12 py-5">
                <h4>User Managment System</h4>
               
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
				                        <td>Address to work</td><td><?php echo $row['address']; ?></td>
				                      </tr>
				                      <tr>
				                        <td>Assign To</td><td><?php echo $row['fullname']; ?></td>
				                      </tr>
				                      <tr>
				                        <td>Status</td><td><?php  if($row['status'] == 1){
											                        echo "In Progress";
											                    }elseif($row['status'] == 2){
											                       echo "Completed";
											                    }else if($row['status'] == 0){
											                      echo "Incomplete";
											                    }else if($row['status'] == 3){
											                      echo "close";
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
                                    <td>Commnet by worker</td>
                                  <td>
                                  
                                  <?php  
                                    echo $record['description'];
                                  ?>
                                  </td>
                                  </tr>
                                  <tr>
                                    <td>Work Image</td>
                                  <td>
                                  
                                  <img id="myImg" src="uploads/<?php  echo $record['picture'] ?>" alt="picture here" width="100" style="display:block;">
                             <?php  $coordinate=$record['coordinate'] ?>
                                  </td>
                                  </tr>
                                
                                   <?php }}

?>
                               
				                    </tbody>
				                  </table>
				                </div>
                        <?php if($coordinate!=null || $coordinate!=''){?>
                        <div class="row m-3">
                          <div class="col-4">
                            <h3>Location </h3>
                          </div>
                          <div class="col-8">
                            
                          <div id="map" class="map"></div>
                           
                          </div>
                         
                        </div>
                        <?php }?>
                        <?php  
                       


?>
                        <?php if($_SESSION['user_role']==1){?>
                        <a title="Update Task"  href="edit-task.php?task_id=<?php echo $_GET['task_id'];?>" class="btn btn-success-custom btn-lg mt-3 float-right ml-3 bg-info">
                                   Update Task </a>
                            <?php } ?>

                                <a   href="task.php" class="btn btn-success-custom btn-lg mt-3 float-right">
                                   Go Back </a>
                                   









          </div>
        </div>
       
<!-- Get the leaflet JavaScript file -->
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity=
"sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script>
    <script>
    // Initialize the leaflet map
const map = L.map('map');

// Get the tile layer from OpenStreetMaps
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

// Specify the maximum zoom of the map
maxZoom: 19,

// Set the attribution for OpenStreetMaps
attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Set the view of the map
// with the latitude, longitude and the zoom value
map.setView([<?php echo $coordinate; ?>], 16);

// Ask for current location and navigate to that area
//console.log(map.locate({setView: true, maxZoom: 16}));
// Show a market at the position of the Eiffel Tower
let eiffelMarker = L.marker([<?php echo $coordinate; ?>]).addTo(map);

// Bind popup to the marker with a popup
eiffelMarker.bindPopup("Employee Location").openPopup();

    </script>
        
        <script>
          // Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
} 
        </script>
        <!-- content viewport ends -->
        <?php  

        include('includes/footer.php');
        ?>
  </body>
</html>