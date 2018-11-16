<?php 

$email = $_POST["name"]; 
$password = $_POST["password"];

if(empty($email) || empty($password))
{
    header('Location: login.html');
}
elseif(!validate($email, $password))
{
    mysqli_close();
    echo "Failure to Login";
    header('Location: login.html');
}
else
{
    setcookie('Email', $email);
    echo "Success!";
    session_start();
    $_SESSION['Email'] = $email;
    mysqli_close();
    header('Location: home.php');
}


function validate($em, $pass)
{
    $user = 'root';
    $pw = 'root';
    $db = 'Meeting';
    $host = 'localhost';
    $port = 8889;

    $conn = mysqli_connect(
        $host, 
        $user, 
        $pw, 
        $db,
        $port
    );

    if (!$conn)
    {

	    echo "Connection failed!";
	    exit;

    }
    $sql = "SELECT * FROM user  WHERE Email LIKE '%$em%' ";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0)
    {
        return 0;
    }
    else
    {
        $row = mysqli_fetch_array($result);
        if (password_verify($pass, $row["Password"])) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}

?>


