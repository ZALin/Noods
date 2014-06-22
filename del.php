<?php
	include_once('config.php');
	session_save_path('./session');
	session_start();
	
	if(isset($_SESSION['permission']) && $_SESSION['permission']=='admin') {
		echo "delete!";
		$del_orderid=$_GET['id'];
		$stmt = mysqli_prepare($con,"DELETE FROM `Order` WHERE `orderID` = ?");
		mysqli_stmt_bind_param($stmt,'s',$del_orderid);
		mysqli_stmt_execute($stmt);
		mysqli_close($con);
		header('Refresh: 1; url=delorder.php');
	}
	else{
		echo "You shall not pass!";
		mysqli_close($con);
		header('Refresh: 3; url=index.php');
	}
	



?>