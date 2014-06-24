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
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='admin' && isset($_SESSION['access']) && $_SESSION['access']==true) {

        $add_shopName=$_POST['shopName'];
        $add_shopPhone=$_POST['shopPhone'];
        $add_shopAddress=$_POST['shopAddress'];

        $stmt = mysqli_prepare($con,"SELECT `shopID` FROM `Shop` WHERE `shopName` = ?");
        mysqli_stmt_bind_param($stmt,'s',$add_shopName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_shopID);
        mysqli_stmt_close($stmt);

        if(mysqli_stmt_num_rows($stmt)==0) {
            $stmt = mysqli_prepare($con,"INSERT INTO `Shop` (`shopID`, `shopName`, `shopPhone`, `shopAddress`) VALUES (NULL, ? , ?, ?)");

            mysqli_stmt_bind_param($stmt,'sss',$add_shopName,$add_shopPhone,$add_shopAddress);

            if(mysqli_stmt_execute($stmt)) {

                echo "<div class='alert alert-success'> " .$add_shopName . " 已經成功加入資料庫 !!<br>Redirecting...</div>";
                

            } else {

                echo "<div class='alert alert-info'> Something Wrong!!<br>Redirecting...</div>";

            }
            
            mysqli_stmt_close($stmt);

        } else {

            echo "<div class='alert alert-info'>".$add_shopName . " 已經存在了<br>Redirecting...</div>";

        }

        if($_SESSION['permission']=='admin') {

            header('Refresh: 1; url=admin.php');

        } else {

            header('Refresh: 1; url=user.php');

        }

    } else {

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