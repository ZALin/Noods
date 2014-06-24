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

                    function pad (str, max) {
                        str = str.toString();
                        return str.length < max ? pad("0" + str, max) : str;
                    }

                    $('#datepicker').datepicker();
                    $('#datepicker').on('keyup mouseup change', function () {
                        var date=$('#datepicker').val().split('/');
                        var year=parseInt(date[2]);
                        var month=parseInt(date[0]);
                        var day=parseInt(date[1]);
                        var sid=<?php echo $_SESSION['shopID'];?>;
                        sid=pad(sid,3);
                        var smid=((year%100)*10000+month*100+day).toString();

                        var phpdate=[date[2],date[0],date[1]].join('-');
                        document.cookie = 'dt='+phpdate; 

                        <?php
                            $stmt = mysqli_prepare($con,'SELECT `shopID` FROM `Order` WHERE `shopID` = ? and orderDate = ?');
                            mysqli_bind_param($stmt,'is',$_SESSION['shopID'],$_COOKIE['dt']);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            mysqli_stmt_bind_result($stmt,$res_shopID);
                            echo "var slast=" .mysqli_stmt_num_rows($stmt) . ";";
                        ?>
                        slast=pad(slast,2);
                        var idstring=[sid,smid,slast].join('-');
                        $('#idlabel').val(idstring);
                    });

                });

                </script>
            </head>
            <body>
                <p>Date: <input type='text' id='datepicker'> </p>
                <form action='add-order-result.php' method='post'>
                    <input id='idlabel' name='orderID' type='hidden'></input><br>
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