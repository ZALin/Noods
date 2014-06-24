<?php

 include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        $productClass=$_POST['productClass'];
        $productName=$_POST['productName'];
        $product_num=$_POST['productNum'];
        $order_id=$_POST['orderid'];
        $has_true_pruductID = false;
        $pruductID_already_exist = false;
        
        $stmt = mysqli_prepare($con,"SELECT `productID` FROM `Product` WHERE `productClass` = ? AND `productName` = ?");
        mysqli_stmt_bind_param($stmt,'ss', $productClass, $productName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_pruductID );
        while(mysqli_stmt_fetch($stmt)) {
            $has_true_pruductID = true;
        }
        if($has_true_pruductID === true){
            // find this pruductID is already exist
            $stmt = mysqli_prepare($con,"SELECT `productNum` FROM `Subscribe` WHERE `orderID` = ? AND `productID` = ? " );
            
            mysqli_stmt_bind_param($stmt,'si', $order_id, $res_pruductID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $res_productNum );
            while(mysqli_stmt_fetch($stmt)) {
                $pruductID_already_exist = true; // already exist
            }
            
            if( $pruductID_already_exist === true ){
                $stmt = mysqli_prepare($con,"UPDATE `Subscribe` SET `productNum` = ? WHERE `orderID` = ? AND `productID` = ?");
                $new_productNum = $product_num + $res_productNum;
                mysqli_stmt_bind_param($stmt,'isi',$new_productNum, $order_id, $res_pruductID);
                $upd_1=mysqli_stmt_execute($stmt);
            }
            else{
                $stmt = mysqli_prepare($con,"INSERT INTO  `Subscribe` ( `subscribeID` , `orderID` , `productID` , `productNum` ) VALUES ( NULL ,  ?,  ?,  ? )");
                mysqli_stmt_bind_param($stmt,'sii',$order_id, $res_pruductID, $product_num);
                $upd_1=mysqli_stmt_execute($stmt);
            }
            
        }
        
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
            if($pruductID_already_exist === true){
                echo "Update! Append is Successful!";
            }
            else{
                echo "Update! Insert is Successful!";
            }
            
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