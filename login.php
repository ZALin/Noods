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

        $stmt = mysqli_prepare($con,'SELECT * FROM Users WHERE username = ? AND password = ?');
        mysqli_stmt_bind_param($stmt,'ss',$index_username,$index_password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $res_username, $res_password, $res_permission);

        

        //echo "Number of rows: ". mysqli_stmt_num_rows($stmt).'<br>';

        while(mysqli_stmt_fetch($stmt)) {
            //printf("%s %s %s\n",$res_username,$res_password,$res_permission);
            //echo $res_username . "<br>";
            //echo $res_password . "<br>";
            //echo $res_permission . "<br>";
        }

        if(mysqli_stmt_num_rows($stmt)==1){
            echo "Welcome!!!" . "<br>" . "Redirecting...";
            $_SESSION['access']=true;
            $_SESSION['username']=$res_username;
            $_SESSION['password']=$res_password;
            $_SESSION['permission']=$res_permission;
            mysqli_stmt_close($stmt);
            
            if ($res_permission == 'admin') {
                header('Refresh: 3; url=admin.php');
            } else {
                header('Refresh: 3; url=user.php');
            }
            
        } else {
            echo "Password error.". "<br>" . "Redirecting...";
            header('Refresh: 3; url=index.php');
        }
        
    } else {
    
        echo "You shall not pass!";
        header('Refresh: 3; url=index.php');

    }

    mysqli_close($con);
?>