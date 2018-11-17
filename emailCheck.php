<?php
    $email = $_GET['Email'];
    
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

    $sql = "SELECT * FROM user";
    $sql .= " WHERE Email LIKE '%$email%' ";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }

?>
