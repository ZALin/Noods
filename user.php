<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {

        echo "<html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - User Page</title>
                    <link rel='stylesheet' type='text/css' href='css/user.css'>
                </head>
                <body>
                    <form action='logout.php' method='post'>
                        <input type='submit' value='登出'>
                    </form>
                    <div id='functions'>
                        <ul>
                          <li><a href='add-order.php'>新增訂單</a></li>
                          <li><a href='listall.php?func=list'>列出本店訂單</a></li>
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
        header('Refresh: 3; url=index.php');
    }
?>