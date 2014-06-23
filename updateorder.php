<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {

        $stmt = mysqli_prepare($con,"SELECT * FROM `Order`");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_orderID ,$res_orderDate ,$res_shopID ,$res_totalCost);

        echo "<table>";
        echo "<tr>";
        echo "<td>訂單ID</td>";
        echo "<td>訂單日期</td>";
        if($_SESSION['admin']==true) {
            echo "<td>shopID</td>";
        }
        echo "<td>總金額</td>";
        echo "<td>修改</td>";
        echo "</tr>";
        while(mysqli_stmt_fetch($stmt)) {
            echo "<tr>";
            echo "<td>".$res_orderID."</td>";
            echo "<td>".$res_orderDate."</td>";
            if($_SESSION['admin']==true) {
                echo "<td>".$res_shopID."</td>";
            }
            echo "<td>".$res_totalCost."</td>";
            echo "<td><a href='UpdatePage.php?id=".$res_orderID."'>修改</a></td>";
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
        header('Refresh: 3; url=index.php');
    }
?>