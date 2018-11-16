<?php
    session_start();

    $email = $_POST['Email'];
    $password = $_POST['Password'];
    //Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $user = 'root';
    $password = 'root';
    $db = 'Meeting';
    $host = 'localhost';
    $port = 8889;

    $conn = mysqli_connect(
        $host, 
        $user, 
        $password, 
        $db,
        $port
    );


    if (!$conn){

        echo "Connection failed!";
        exit;

    }

    $sql = "INSERT INTO user (Email, Password) VALUES ('$email', '$hash')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    }

    $_SESSION["email"] = $email;


?>