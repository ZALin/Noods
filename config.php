<?php
    $con = mysqli_connect("sql5.freesqldatabase.com","sql544303","eT2*wK6*","sql544303");
    mysqli_set_charset($con,"utf8");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    /*$databasename = 'sql544303';
    $username = 'sql544303';
    $password = 'eT2*wK6*';
    $hostname = 'localhost';
     
    $link = mysql_connect($hostname, $username, $password);
    if (!$link) {
        die('Not connected : ' . mysql_error());
    }
     
    // make foo the current db
    $db = mysql_select_db($databasename, $link);
    if (!$db) {
        die ('Can\'t connect : ' . mysql_error());
    }*/
?>