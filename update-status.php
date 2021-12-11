<?php
require 'includes/auth.php'; // admin authentication check 
$date=$_GET['date'];
echo $obj_admin->updateStatus($date);


?>