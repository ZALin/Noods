<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {

        echo "<html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - Search Page</title>
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
        echo "<form action='search-result.php' method='post'>
                        <label> 店名： </label>";
                        
        echo "           <select name='shopName'>";

        $stmt = mysqli_prepare($con,"SELECT `shopName` FROM `Shop`");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_shopName);
        while(mysqli_stmt_fetch($stmt)) {
            echo "<option value='".$res_shopName."'>".$res_shopName."</option>";
        }

        echo "           </select><br>";
        echo "<input type='submit' class='btn btn-primary' value='查詢'>";

        echo "       </form><br>";
        /*
        if($_SESSION['permission']=='admin') {
            echo "<a href='admin.php'>back to main page</a>";
        } else {
            echo "<a href='user.php'>back to main page</a>";
        }*/

        echo "    </body>
              </html>";
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else {
        echo " <html>
                <head>
                    <title>Error</title>
                    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                </head>
                <body><div class='alert alert-error'> <h1>You shall not pass!</h1></div></body></html>";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>