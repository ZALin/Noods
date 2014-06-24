<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        
    echo "<html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - List Page</title>
                    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                </head>
                <body>";
        
if($_SESSION['permission']=='admin') {
    echo "<div class='navbar navbar-inverse'>
            <div class='navbar-inner'>
                <div class='container'>
                    <a class='brand' href='admin.php'><i class='icon-play icon-white'></i>  Admin Home Page</a>                                
                    <div class='nav-collapse collapse'>
                        <form action='logout.php' method='post' class='navbar-form pull-right'>
                            <input class='btn' type='submit' value='登出'>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
} else {
    echo " <div class='navbar'>
            <div class='navbar-inner'>
                <div class='container'>
                    <a class='brand' href='user.php'><i class='icon-play'></i>  User Home Page</a>                                
                    <div class='nav-collapse collapse'>
                        <form action='logout.php' method='post' class='navbar-form pull-right'>
                            <input class='btn btn-inverse' type='submit' value='登出'>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
}
        

        if($_SESSION['permission'] == 'admin') {
            $stmt = mysqli_prepare($con,"SELECT * FROM `Order`");
        } else {
            $stmt = mysqli_prepare($con,"SELECT * FROM `Order` WHERE `shopID` = ?");
            mysqli_stmt_bind_param($stmt,'i',$_SESSION['shopID']);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_orderID ,$res_orderDate ,$res_shopID ,$res_totalCost);

        echo "<table class='table table-striped' >";
        echo "<tr>";
        echo "<th>訂單ID</th>";
        echo "<th>訂單日期</th>";
        if($_SESSION['permission'] == 'admin') {
            echo "<th>shopID</th>";
        }
        echo "<th>總金額</th>";
        if($_GET['func'] == 'modify') {
            echo "<th>修改</th>";
        }
        if($_GET['func'] == 'delete') {
            echo "<th>刪除</th>";
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
        
        /*
        if($_SESSION['permission']=='admin') {
            echo "<a href='admin.php'>back to main page</a>";
        } else {
            echo "<a href='user.php'>back to main page</a>";
        }*/
        echo "    </body>
              </html>";
        mysqli_close($con);
    } else {
        echo "<html>
                <head>
                    <title>Error</title>
                    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                </head>
                <body><div class='alert alert-error'> <h1>You shall not pass!</h1></div></body></html>";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>