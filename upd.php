<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='admin') {
        $oid=$_POST['oid'];
        $pid=$_POST['pid'];
        $num=$_POST['num'];
        $stmt = mysqli_prepare($con,"UPDATE `Subscribe` SET `productNum` = ? WHERE `orderID` = ? AND `productID` = ?");
        mysqli_stmt_bind_param($stmt,'sss',$num, $oid, $pid);
        mysqli_stmt_execute($stmt);
        
        //calculate totalCost
        $stmt = mysqli_prepare($con,"SELECT * FROM `Subscribe` NATURAL JOIN `Product` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$oid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_productID, $res_subscribeID, $res_orderID, $res_pruductNum, $res_productClass, $res_productName, $res_productCost);
        $total_cost = 0;
        while(mysqli_stmt_fetch($stmt)) {
            $total_cost += $res_pruductNum*$res_productCost;
        }      
        $stmt = mysqli_prepare($con,"UPDATE `Order` SET `totalCost` = ? WHERE `orderID` = ? ");
        mysqli_stmt_bind_param($stmt,'ss',$total_cost, $oid);
        mysqli_stmt_execute($stmt);
        
        echo "Update!";
        mysqli_close($con);
        header("Refresh: 1; url=updateorder.php");
    }
    else{
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 3; url=index.php');
    }
    



?>