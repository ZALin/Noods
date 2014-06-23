<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        


        if($_SESSION['permission'] == 'admin') {
            $stmt = mysqli_prepare($con,"SELECT * FROM `Order`");
        } else {
            $stmt = mysqli_prepare($con,"SELECT * FROM `Order` WHERE `shopID` = ?");
            mysqli_stmt_bind_param($stmt,'i',$_SESSION['shopID']);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_orderID ,$res_orderDate ,$res_shopID ,$res_totalCost);

        echo "<table>";
        echo "<tr>";
        echo "<td>訂單ID</td>";
        echo "<td>訂單日期</td>";
        if($_SESSION['permission'] == 'admin') {
            echo "<td>shopID</td>";
        }
        echo "<td>總金額</td>";
        if($_GET['func'] == 'modify') {
            echo "<td>修改</td>";
        }
        if($_GET['func'] == 'delete') {
            echo "<td>刪除</td>";
        }
        echo "</tr>";
        while(mysqli_stmt_fetch($stmt)) {

            echo "<tr>";
            echo "<td>".$res_orderID."</td>";
            echo "<td>".$res_orderDate."</td>";
            if($_SESSION['permission'] == 'admin') {
                echo "<td>".$res_shopID."</td>";
            }
            echo "<td>".$res_totalCost."</td>";

            if($_GET['func'] == 'modify') {
                echo "<td><a href='update.php?id=".$res_orderID."'>修改</a></td>";
            }

            if($_GET['func'] == 'delete') {
                echo "<td><a href='delorder-result.php?id=".$res_orderID."'>刪除</a></td>";
            }

            echo "</tr>";
        }
                
        echo "</table><br>";

        if($_SESSION['permission']=='admin') {
            echo "<a href='admin.php'>back to main page</a>";
        } else {
            echo "<a href='user.php'>back to main page</a>";
        }

        mysqli_close($con);
    } else {
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>