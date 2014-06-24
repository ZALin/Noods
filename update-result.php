<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        $order_id=$_POST['oid'];
        $product_id=$_POST['pid'];
        $product_num=$_POST['num'];
        $stmt = mysqli_prepare($con,"UPDATE `Subscribe` SET `productNum` = ? WHERE `orderID` = ? AND `productID` = ?");
        mysqli_stmt_bind_param($stmt,'sss',$product_num, $order_id, $product_id);
        $upd_1=mysqli_stmt_execute($stmt);
        
        //calculate totalCost
        $stmt = mysqli_prepare($con,"SELECT `productNum`,`productCost` FROM `Subscribe` NATURAL JOIN `Product` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_pruductNum,  $res_productCost);

        $total_cost = 0;
        while(mysqli_stmt_fetch($stmt)) {
            $total_cost += $res_pruductNum*$res_productCost;
        }
        //END calculate totalCost
        
        $stmt = mysqli_prepare($con,"UPDATE `Order` SET `totalCost` = ? WHERE `orderID` = ? ");
        mysqli_stmt_bind_param($stmt,'ss',$total_cost, $order_id);
        $upd_2=mysqli_stmt_execute($stmt);
        if($upd_1 && $upd_2){
            echo "Update!";
        } else {
            echo "Update! Fail!";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        header("Refresh: 1; url=update.php?id=".$order_id);
    }
    else{
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 3; url=index.php');
    }
    



?>