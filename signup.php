<?php
session_start();
if(isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("location: home1.php");
}
?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="signup.css" type="text/css" rel="stylesheet">
        <script src="jquery-3.3.1.js"></script>
        <script src="signup.js"></script>
    </head>
    <body>
        <div id = "signupForm">
        <div class = "row">
             <div class = "col-12">
                 <h1>Welcome to Meeting Master</h1></br>
                <h3>Sign Up</h3>
                <p>Please fill in this form to create an account</p>
                <p id = "errormessage"></p>
            </div>
        </div>
        <form>
            <div class = "form-row">
                <div class = "col-12">
                    <input type = "text" class ="form-control" id = "Email" placeholder="Email" novalidate> 
                </div>
            </div>
            <div class = "form-row">
                <div class = "col-12">
                    <input type = "password" class ="form-control" id = "Password" placeholder="Password">
                </div>
            </div>
            <div class = "form-row">
                <div class = "col-12">
                    <input type = "password" class ="form-control" id = "ConfirmPassword" placeholder="Confirm Password">
                </div>
            </div>
            <div class = "form-row">
                <button type="submit" class="btn btn-primary">Sign Up </button>
                </br>
            </div>
            <div class = "form-row">
                <a href = "login.php">Already signed up?</a>
            </div>
        </form>
    </div>
    </body>
</html>