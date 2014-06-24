<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='user' && isset($_SESSION['access']) && $_SESSION['access']==true) {
        $add_orderdate=$_POST['orderDate'];
        $add_date=explode("-", $add_orderdate);
        $add_shopID=$_SESSION['shopID'];

        $stmt = mysqli_prepare($con,'SELECT `orderID` FROM `Order` WHERE `shopID` = ? AND orderDate = ?');
        mysqli_stmt_bind_param($stmt,'is',$add_shopID,$add_orderdate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_orderID);
        while(mysqli_stmt_fetch($stmt)) {
            //echo $res_orderID . "<br>";
        }

        $nrow=mysqli_stmt_num_rows($stmt);

        mysqli_stmt_close($stmt);

        if($nrow<10){
            $nrow = "0" . $nrow;
        }
        if($add_shopID<10) {
            $add_shopID = "00" .$add_shopID;
        } else if ($add_shopID < 99){
            $add_shopID = "0" .$add_shopID;
        }


        $add_orderid = $add_shopID."-".$add_date[0][2].$add_date[0][3].$add_date[1].$add_date[2]."-".$nrow;

        $stmt = mysqli_prepare($con,"INSERT INTO `Order` (`orderID`, `orderDate`, `shopID`, `totalCost`) VALUES ( ? , ? , ?, 0)");
        mysqli_stmt_bind_param($stmt,'ssi',$add_orderid,$add_orderdate,$_SESSION['shopID']);

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