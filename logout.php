<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    $_SESSION['access']=false;
?>

<?php
    
    

    mysqli_close($con);
?>