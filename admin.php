<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {

        echo "<html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - Admin Page</title>
                    <link rel='stylesheet' type='text/css' href='css/admin.css'>
                </head>
                <body>
                    <form action='logout.php' method='post'>
                        <input type='submit' value='登出'>
                    </form>
                    <div id='functions'>
                        <ul>
                          <li><a href='add-shop.php'>新增店家</a></li>
                          <li><a href='search.php'>查詢店家訂單</a></li>
                          <li><a href='listall.php?func=list'>列出所有訂單</a></li>
                          <li><a href='listall.php?func=modify'>修改訂單</a></li>
                          <li><a href='listall.php?func=delete'>刪除訂單</a></li>
                        </ul>
                    </div>
                </body>
            </html>";

        mysqli_close($con);
    } else {
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>