<?php 

$name = $_POST["name"]; 
$password = $_POST["password"];

if(empty($name) || empty($password))
{
    header('Location: login.html');
}
elseif(!validate($name, $password))
{
    mysqli_close();
    header('Location: login.html');
}
else
{
    setcookie('Name', $name);
    echo "Success!";
    session_start();
    $_SESSION['username'] = $name;
    mysqli_close();
    header('Location: books.php');
}


function validate($un, $pass)
{
    echo "2";
    $user = 'root';
    $pw = 'root';
    $db = 'bookstore';
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
    $sql = "SELECT * FROM User";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result))
    {
        if($un == $row["UserName"] && $pass == $row["Password"])
            return 1;
    
    }
    return 0;
}

?>


