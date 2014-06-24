<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/index.css" rel="stylesheet" type="text/css">
    <title>Noods</title>
    </head>
    <body>
        <div id='loginpanel'>
            <form action='login.php' method='post' class='form-horizontal'>
                <div class="control-group">
                    <label class="control-label" for="username"> 帳號: </label>
                    <div class="controls">
                        <input type='text' name='username' id='username' placeholder='username'><br>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password"> 密碼: </label>
                    <div class="controls">
                        <input type='password' name='password' id='password' placeholder='password'><br>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type='submit' class='btn btn-primary' value='登入'>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>