<?php
session_start();
if(isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("location: home1.php");
}
$message = $_GET['message'];
?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="login.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div id = "loginForm">
        <div class = "row">
            <div class = "col-12">
                <h1>Welcome Back to Meeting Master</h1></br>
                <h3>Login</h3>
            </div>
        </div>
        <form action="login1.php" method="post">
            <div class = "form-row">
                <div class = "col-12">
                    <input type= "text" name= "name" class ="form-control" placeholder="Email">
                </div>
            </div>
            <div class = "form-row">
                <div class = "col-12">
                    <input type= "password" name= "password" class ="form-control" placeholder="Password">
                </div>
            </div>
            <div class = "form-row">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <?php
                if($message == 1)
                {
                    echo "<p id ='errorMessage'>Login Failed</p>";
                }
            ?>
            <div class = "form-row">
                <a href = "signup.php">Sign up here</a>
            </div>
        </form>
        </div>
    </body>
</html>

