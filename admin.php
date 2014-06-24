<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
?>
<!DOCTYPE html>
<?php
    if(isset($_SESSION['access']) && $_SESSION['access']==true) {

        echo "<html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - Admin Page</title>
                    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                </head>
                <body>
                    <div class='navbar navbar-inverse'>
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
                    </div>
                    <div id='functions'>
                        <ul class='nav nav-pills nav-stacked'>
                          <li><a href='add-shop.php' style='color:#000000'><i class='icon-home'></i>　新增店家</a></li>
                          <li><a href='search.php' style='color:#000000'><i class='icon-search '></i>　查詢店家訂單</a></li>
                          <li><a href='listall.php?func=list' style='color:#000000'><i class='icon-th-list'></i>　列出所有訂單</a></li>
                          <li><a href='listall.php?func=modify' style='color:#000000'><i class='icon-wrench '></i>　修改訂單</a></li>
                          <li><a href='listall.php?func=delete' style='color:#000000'><i class='icon-trash'></i>　刪除訂單</a></li>
                        </ul>
                    </div>
                </body>
            </html>";

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