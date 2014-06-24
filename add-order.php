<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='user' && isset($_SESSION['access']) && $_SESSION['access']==true) {
        
        echo "<html>
                <head>
                    <meta http-equiv='Content-Type' content='charset=utf-8'>
                    <title>Noods - Add-Order Page</title>
                    <script src='js/jquery-1.10.2.js'></script>
                    <script src='js/jquery-ui-1.10.4.custom.js'></script>

                    <link href='css/ui-lightness/jquery-ui-1.10.4.custom.css' rel='stylesheet'>
                    <link rel='stylesheet' type='text/css' href='css/add-order.css'>
                </head>
                <body>
                     <form action='add-order-result.php' method='post'>
                        <label></label>
                        <input type='text' name=''><br>
                        <label></label>
                        <input type='text' name=''><br>
                        <label></label>
                        <input type='text' name=''><br>
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