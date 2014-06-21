<?php
    include_once('config.php');
    session_save_path('./session');
    session_start();
    $_SESSION['access']=false;
?>

<?php
    
    if($_POST['username']!=null && $_POST['password']!=null) {

        $index_username=$_POST['username'];
        $index_password=$_POST['password'];

        //$sql = "SELECT * FROM Users ";
        $sql = "SELECT * FROM Users WHERE username = ? and password = ?";
        //$result = mysqli_query($con,$sql);

        $stmt = mysqli_prepare($con,'SELECT * FROM Users WHERE username = ? AND password = ?');
        mysqli_stmt_bind_param($stmt,'ss',$index_username,$index_password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        //mysqli_stmt_bind_result($stmt, $res_username, $res_password, $res_permission);

        //echo "Number of rows: ". mysqli_stmt_num_rows($stmt).'<br>';

        /*while(mysqli_stmt_fetch($stmt)) {
            printf("%s %s %s\n",$res_username,$res_password,$res_permission);
        }*/
        if(mysqli_stmt_num_rows($stmt)==1){
            echo "Welcome!!!" . "<br>" . "Redirecting...";
            $_SESSION['access']=true;
            mysqli_stmt_close($stmt);
            header('Refresh: 3; url=search.php');
        } else {
            echo "password error". "<br>" . "Redirecting...";
            header('Refresh: 3; url=index.php');
        }
        
        
    } else {
    
        echo "Permission Not Enough!";
        header('Refresh: 5; url=index.php');

    }

    mysqli_close($con);
?>