<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    </head>
    <body>
<?php      
    if(isset($_SESSION['access']) && $_SESSION['access']==true) {

        $del_orderid=$_GET['id'];
        $stmt = mysqli_prepare($con,"DELETE FROM `Order` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$del_orderid);
        $dela=mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($con,"DELETE FROM `Subscribe` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$del_orderid);
        $delb=mysqli_stmt_execute($stmt);

        if($dela && $delb) {

            echo "<div class='alert alert-success'>". $del_orderid . " 已經成功刪除 !!<br>Redirecting...</div>";
            

        } else {

            echo "<div class='alert alert-info'> Something Wrong!!<br>Redirecting... </div>";

        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);

        if($_SESSION['permission']=='admin') {
            header('Refresh: 2; url=admin.php');
        } else {
            header('Refresh: 2; url=user.php');
        }
    }
    else{
        echo "<html>
                <head>
                    <title>Error</title>
                    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                </head>
                <body><div class='alert alert-error'> <h1>You shall not pass!</h1></div></body></html>";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>
</body>
</html>