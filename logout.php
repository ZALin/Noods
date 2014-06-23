<?php
    session_save_path('./session');
    session_start();
    session_destroy();
    echo "See you.". "<br>" . "Redirecting...";
    header('Refresh: 1; url=index.php');
?>