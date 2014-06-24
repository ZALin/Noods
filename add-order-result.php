<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='user' && isset($_SESSION['access']) && $_SESSION['access']==true) {
        header('Refresh: 2; url=update.php?id=' . $_POST['orderID']);
        mysqli_close($con);
    }
    else{
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>