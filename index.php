<?php
	session_save_path('./session');
	session_start();
    $_SESSION['validated']=true;
    session_write_close();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Noods</title>
    </head>
    <body>
		<form action='login.php' method='post'>
			<label> 帳號: </label>
			<input type='text' name='username' id='username'><br>
			<label> 密碼: </label>
			<input type='password' name='password' id='password'><br>
			<input type='submit' value='登入'>
		</form>
    </body>
</html>