<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='admin' && isset($_SESSION['access']) && $_SESSION['access']==true) {
        
        echo "<!DOCTYPE html>
                <html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - Add-Shop Page</title>
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
                echo "<form class='form-horizontal' action='add-shop-result.php' method='post'>
                     <div class='control-group'>
                        <label class='control-label' for='shopName'> 店名： </label>
                        <div class='controls'>
                        <input type='text' name='shopName'  placeholder='shopName' ><br>
                        </div>
                     </div>
                     <div class='control-group'>
                        <label class='control-label' for='shopPhone'> 電話： </label>
                        <div class='controls'>
                        <input type='text' name='shopPhone' placeholder='shopPhone'><br>
                        </div>
                     </div>   
                     <div class='control-group'>
                        <label class='control-label' for='shopAddress'> 地址： </label>
                        <div class='controls'>
                        <input type='text' name='shopAddress' placeholder='shopAddress'><br>
                        </div>
                     <div class='control-group'>
                     <div class='controls'>
                        <label>    <br>  </label>
                        <input type='submit' class='btn btn-primary' value='新增'>
                        </div>
                     </div>   
                    </form>
                </body>
              </html>";
    }
    else{
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