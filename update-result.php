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
        echo "Update!";
        //to do  calculate totalCost
        header('Refresh: 1; url=UpdatePage.php');
    }
    else{
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 3; url=index.php');
    }
    



?>