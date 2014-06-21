<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();

    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        $admin_access=true;
    } else {
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 3; url=index.php');
    }
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="charset=utf-8">
    <title>Noods - Admin Page</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">

    </head>
    <body>
        <div id='functions'>
            <ul>
              <li>新增店家</li>
              <li>查詢店家訂單</li>
              <li>列出所有訂單</li>
              <li>修改</li>
              <li>刪除訂單</li>
            </ul>
        </div>
    </body>
</html>


<?php
    mysqli_close($con);
?>