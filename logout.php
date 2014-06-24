<?php
    session_save_path('./session');
    session_start();
    session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <title>Now logout...</title>
    </head>
    <body>
<?php
    echo " <div class='hero-unit'> <div class='alert alert-info'> <h1>See you</h1><br> <h3>Redirecting...</h3></div></div>";
    header('Refresh: 1; url=index.php');
?>
    </body>
</html>