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
        $order_id=$_POST['oid'];
        $product_id=$_POST['pid'];
        
        $stmt = mysqli_prepare($con,"DELETE FROM `Subscribe` WHERE `orderID` = ? AND `productID` = ?");
        mysqli_stmt_bind_param($stmt,'si',$order_id, $product_id);
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
            echo "<div class='alert alert-success'> Delete!  </div>";
        } else {
            echo " <div class='alert alert-info'> Delete Fail! </div>";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        header("Refresh: 1; url=update.php?id=".$order_id);
    }
    else{
        echo "<html>
                <head>
                    <title>Error</title>
                    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                </head>
                <body><div class='alert alert-error'> <h1>You shall not pass!</h1></div></body></html>";
        mysqli_close($con);
        header('Refresh: 3; url=index.php');
    }
    



?>

</body>
</html>