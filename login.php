<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    $_SESSION['access']=false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <title>Now login...</title>
    </head>
    <body>
<?php
    
    if($_POST['username']!=null && $_POST['password']!=null) {

        $index_username=$_POST['username'];
        $index_password=$_POST['password'];

        $stmt = mysqli_prepare($con,'SELECT * FROM `Users` WHERE `username` = ? AND `password` = ?');
        mysqli_stmt_bind_param($stmt,'ss',$index_username,$index_password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_username, $res_password, $res_permission, $res_shopID);


        if(mysqli_stmt_num_rows($stmt)==1) {
            echo "<div class='hero-unit'> <div class='alert alert-success'> <h1>Welcome!!! $index_username </h1> <br> <h3>Redirecting...</h3></div></div>";

            $_SESSION['access']=true;
            while (mysqli_stmt_fetch($stmt)) {
                $_SESSION['username']=$res_username;
                $_SESSION['password']=$res_password;
                $_SESSION['permission']=$res_permission;
                $_SESSION['shopID']=$res_shopID;
            }
            mysqli_stmt_close($stmt);
            
            if ($res_permission == 'admin') {
                header('Refresh: 1; url=admin.php');
            } else {
                header('Refresh: 1; url=user.php');
            }
            
        } else {
            echo "<div class='hero-unit'>  <div class='alert alert-error'> <h1>Password Error!!!</h1> <br> <h3>Redirecting...</h3>  </div></div>";
            header('Refresh: 2; url=index.php');
        }
        
    } else {
    
        echo "You shall not pass!";
        header('Refresh: 2; url=index.php');

    }

    mysqli_close($con);
?>
</body>
</html>