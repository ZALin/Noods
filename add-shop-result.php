<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
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

                echo $add_shopName . " 已經成功加入資料庫 !!<br>Redirecting...";
                

            } else {

                echo "Something Wrong!!<br>Redirecting...";

            }
            
            mysqli_stmt_close($stmt);

        } else {

            echo $add_shopName . " 已經存在了<br>Redirecting...";

        }

        if($_SESSION['permission']=='admin') {

            header('Refresh: 1; url=admin.php');

        } else {

            header('Refresh: 1; url=user.php');

        }

    } else {

        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');

    }
?>