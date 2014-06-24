<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        echo "delete!";
        $del_orderid=$_GET['id'];
        $stmt = mysqli_prepare($con,"DELETE FROM `Order` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$del_orderid);
        $dela=mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($con,"DELETE FROM `Subscribe` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$del_orderid);
        $delb=mysqli_stmt_execute($stmt);

        if($dela && $delb) {

            echo $del_orderid . " 已經成功刪除 !!<br>Redirecting...";
            

        } else {

            echo "Something Wrong!!<br>Redirecting...";

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
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>