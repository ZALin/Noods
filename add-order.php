<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    
    if(isset($_SESSION['permission']) && $_SESSION['permission']=='user' && isset($_SESSION['access']) && $_SESSION['access']==true) {
?>        
        <html>
            <head>
                <meta http-equiv='Content-Type' content='charset=utf-8'>
                <title>Noods - Add-Order Page</title>
                <script src='js/jquery-1.10.2.js'></script>
                <script src='js/jquery-ui-1.10.4.custom.js'></script>
                
                <link rel='stylesheet' href='css/ui-lightness/jquery-ui-1.10.4.custom.css'>
                <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                <script>
                
                $(function() {

                    $('#datepicker').datepicker();
                    $('#datepicker').on('keyup mouseup change', function () {
                        var date=$('#datepicker').val().split('/');

                        var phpdate=[date[2],date[0],date[1]].join('-');
                        $('#datelabel').val(phpdate);
                    });

                });

                </script>
            </head>
            <body>
<?php
if($_SESSION['permission']=='admin') {
    echo "<div class='navbar navbar-inverse'>
            <div class='navbar-inner'>
                <div class='container'>
                    <a class='brand' href='admin.php'><i class='icon-play icon-white'></i>  Admin Home Page</a>                                
                    <div class='nav-collapse collapse'>
                        <form action='logout.php' method='post' class='navbar-form pull-right'>
                            <input class='btn' type='submit' value='登出'>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
} else {
    echo " <div class='navbar'>
            <div class='navbar-inner'>
                <div class='container'>
                    <a class='brand' href='user.php'><i class='icon-play'></i>  User Home Page</a>                                
                    <div class='nav-collapse collapse'>
                        <form action='logout.php' method='post' class='navbar-form pull-right'>
                            <input class='btn btn-inverse' type='submit' value='登出'>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
}
?>                
                <p>Date: <input type='text' id='datepicker'> </p>
                <form action='add-order-result.php' method='post'>
                    <input id='datelabel' name='orderDate' type='hidden'></input><br>
                    <input type='submit' class='btn btn-primary' value='新增'>
                </form>
            </body>
        </html>
<?php
    }
    else{
        echo "<html>
                <head>
                    <title>Error</title>
                    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
                </head>
                <body><div class='alert alert-error'> <h1>You shall not pass!</h1></div></body></html>";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>