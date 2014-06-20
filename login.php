<?php
	include('config.php');
	session_save_path('./session');
	session_start();
	
	if(isset($_SESSION['view'])) {
		
		$index_username=$_POST['username'];
		$index_password=$_POST['password'];
		echo $index_username;
		echo $index_password;
		
	} else {
	
		echo "Permission Not Enough!";
		header('Refresh: 5; url=index.html');
		
	}
	
?>