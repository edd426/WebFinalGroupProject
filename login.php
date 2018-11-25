<?php 

$user = 'root';
$pw = 'root';
$db = 'meeting';
$host = 'localhost';
$port = 3306;

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

$email = $_POST["name"]; 
$password = $_POST["password"];

if(empty($email) || empty($password))
{
    mysqli_close();
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
    session_start();
    //Store userid in $_SESSION
    $sql = "SELECT user.UserID FROM user WHERE user.Email='$email';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $_SESSION['userid'] = $row['UserID'];
    //Store admin in $_SESSION
    $sql = "SELECT user.UserID FROM user,admin WHERE user.UserID='".$_SESSION['userid'].
        "' AND admin.UserID=user.UserID;";
    $result = mysqli_query($conn, $sql);
    $_SESSION['admin'] = (mysqli_num_rows($result)==0) ? false : true;
    mysqli_close();
    header('Location: home.html');
}


function validate($em, $pass)
{
    $user = 'root';
    $pw = 'root';
    $db = 'meeting';
    $host = 'localhost';
    $port = 3306;

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
            echo $conn;
	    exit;

    }
    $sql = "SELECT * FROM user WHERE Email LIKE '%$em%';";
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


