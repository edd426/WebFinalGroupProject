<?php
    session_start();

    $email = $_POST['Email'];
    $password = $_POST['Password'];
    //Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $user = 'root';
    $password = 'root';
    $db = 'meeting';
    $host = 'localhost';
    $port = 3306;

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

    //Store userid in $_SESSION
    $sql = "SELECT user.UserID FROM user WHERE user.Email LIKE '%$email%';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $_SESSION['userid'] = $row['UserID'];
    //Store admin in $_SESSION
    $sql = "SELECT user.UserID FROM user,admin WHERE user.UserID='".$_SESSION['userid'].
        "' AND admin.UserID=user.UserID;";
    $result = mysqli_query($conn, $sql);
    $_SESSION['admin'] = (mysqli_num_rows($result)==0) ? false : true;
    mysqli_close();


?>
