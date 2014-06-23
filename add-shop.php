<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='admin' && isset($_SESSION['access']) && $_SESSION['access']==true) {
        
        echo "<html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - Add-Shop Page</title>
                    <link rel='stylesheet' type='text/css' href='css/add-shop.css'>
                </head>
                <body>
                     <form action='add-shop-result.php' method='post'>
                        <label> 店名： </label>
                        <input type='text' name='shopName'><br>
                        <label> 電話： </label>
                        <input type='text' name='shopPhone'><br>
                        <label> 地址： </label>
                        <input type='text' name='shopAddress'><br>
                        <input type='submit' value='新增'>
                    </form>
                </body>
              </html>";
    }
    else{
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>