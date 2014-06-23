<?php
	include_once('config.php');
	session_save_path('./session');
	session_start();

	if(isset($_SESSION['access']) && $_SESSION['access']==true) {

		echo "<html>
				<head>
					<meta http-equiv='Content-Type' content='charset=utf-8'>
					<title>Noods - Search Page</title>
					<link rel='stylesheet' type='text/css' href='css/search.css'>
				</head>
				<body>
					 <form action='search-result.php' method='post'>
						<label> 店名： </label>";
						
		echo "		   <select name='shopName'>";

		$stmt = mysqli_prepare($con,"SELECT DISTINCT shopName FROM Shop");
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $res_shopName);
		while(mysqli_stmt_fetch($stmt)) {
			echo "<option value='".$res_shopName."'>".$res_shopName."</option>";
		}

		echo "		   </select><br>";
		echo "<input type='submit' value='查詢'>";

		echo "	   </form><br>";

		if($_SESSION['permission']=='admin') {
			echo "<a href='admin.php'>back to main page</a>";
		} else {
			echo "<a href='user.php'>back to main page</a>";
		}

		echo "	</body>
			  </html>";
		mysqli_stmt_close($stmt);
		mysqli_close($con);
	} else {
		echo "You shall not pass!";
		mysqli_close($con);
		header('Refresh: 2; url=index.php');
	}
?>