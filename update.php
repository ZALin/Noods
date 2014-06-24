<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        $upd_orderid=$_GET['id'];
        $stmt = mysqli_prepare($con,"SELECT * FROM `Order` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$upd_orderid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_orderID ,$res_orderDate ,$res_shopID ,$res_totalCost);

        //list the order which been select
        echo "<table>";
        echo "<tr>";
        if($_SESSION['permission']=='admin') {
            echo "<th colspan=4>";
        }
        else{
            echo "<th colspan=3>";
        }
        echo "要修改的訂單:</th></tr>";
        echo "<tr>";
        echo "<td>訂單ID</td>";
        echo "<td>訂單日期</td>";
        if($_SESSION['permission']=='admin') {
            echo "<td>shopID</td>";
        }
        echo "<td>總金額</td>";
        echo "</tr>";
        while(mysqli_stmt_fetch($stmt)) {
            echo "<tr>";
            echo "<td>".$res_orderID."</td>";
            echo "<td>".$res_orderDate."</td>";
            if($_SESSION['permission']=='admin') {
                echo "<td>".$res_shopID."</td>";
            }
            echo "<td>".$res_totalCost."</td>";
            echo "</tr>";
        }      
        echo "</table><br>";
        //END list the order which been select 

        
        $stmt = mysqli_prepare($con,"SELECT * FROM `Subscribe` NATURAL JOIN `Product` WHERE `orderID` = ?");
        mysqli_stmt_bind_param($stmt,'s',$upd_orderid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_productID, $res_subscribeID, $res_orderID, $res_pruductNum, $res_productClass, $res_productName, $res_productCost);
        
        // `Subscribe` should not have subscribeID in our design

        
        echo "<table>";
        echo "<tr>";
        echo "<th>類別</th>"; 
        echo "<th>名稱</th>";
        echo "<th>單價</th>";
        echo "<th>數量</th>";
        echo "</tr>";
        echo "<tr>";
        while(mysqli_stmt_fetch($stmt)) {
            echo "<tr>";
            echo "<td>".$res_productClass."</td>";
            echo "<td>".$res_productName."</td>";
            echo "<td>".$res_productCost."</td>";
            echo "<td>
                    <form action='upd.php' method='post'>
                        <input type='text' value=".$res_pruductNum." name='num'>
                        <input type='hidden' value=".$upd_orderid." name='oid'>
                        <input type='hidden' value=".$res_productID." name='pid'>
                        <input type='submit' value='修改'>
                    </form>
                 </td>";
            echo "</tr>";
        }      
        echo "</table><br>";
        
        
        if($_SESSION['permission']=='admin') {
            echo "<a href='admin.php'>back to main page</a>";
        } else {
            echo "<a href='user.php'>back to main page</a>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else {
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 3; url=index.php');
    }
?>