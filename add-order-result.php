<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='user' && isset($_SESSION['access']) && $_SESSION['access']==true) {
        $add_orderid=$_POST['orderID'];
        $add_orderdate=$_POST['orderDate'];

        $stmt = mysqli_prepare($con,"INSERT INTO `Order` (`orderID`, `orderDate`, `shopID`, `totalCost`) VALUES ( ? , ? , ?, 0)");

        mysqli_stmt_bind_param($stmt,'sss',$add_orderid,$add_orderdate,$_SESSION['shopID']);

        if(mysqli_stmt_execute($stmt)) {

            echo $add_orderid . " 已經成功加入資料庫 !!<br>Redirecting...";
            

        } else {

            echo "Something Wrong!!<br>Redirecting...";

        }
        
        mysqli_stmt_close($stmt);
        header('Refresh: 1; url=update.php?id=' . $add_orderid);
        mysqli_close($con);
    }
    else{
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>