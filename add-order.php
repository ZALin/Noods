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
                
                <p>Date: <input type='text' id='datepicker'> </p>
                <form action='add-order-result.php' method='post'>
                    <input id='datelabel' name='orderDate' type='hidden'></input><br>
                    <input type='submit' value='新增'>
                </form>
            </body>
        </html>
<?php
    }
    else{
        echo "You shall not pass!";
        mysqli_close($con);
        header('Refresh: 2; url=index.php');
    }
?>