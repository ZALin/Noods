<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
?>


<?php
    if(isset($_SESSION['access']) && $_SESSION['access']==true) {
        echo "search!";
    } else {
        echo "you shall not pass";
    }
    mysqli_close($con);
?>