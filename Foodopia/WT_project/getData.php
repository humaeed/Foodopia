<?php
	session_start();
	$con=mysqli_connect("localhost","root","","restaurant_system");
	$str="UPDATE `location` SET `longitude` = '".$_GET['lng']."', `latitude` = '".$_GET['lat']."' WHERE `location`.`location_id` = '".$_SESSION['location_id']."';";
		mysqli_query($con,$str);
		//echo $_GET['lng'];
		header("location: res_prof.php"); 
?>