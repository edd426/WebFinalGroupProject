
<?php
//Start session
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("Location: login.html");
}

$dbuser = 'root';
$dbpass = 'root';
$db = 'meeting';
$host = 'localhost';
$port = 3306;

$conn = mysqli_connect(
   $host, 
   $dbuser, 
   $dbpass, 
   $db,
   $port
);


if (!$conn){
	echo "Connection failed!";
	exit;
}

$userid=$_SESSION['userid'];
$roomid=$_GET['roomid'];

if(isset($_GET['roomid'])){
    $roomid=$_GET['roomid'];
    $sql = "INSERT INTO favorite (UserID, RoomID) VALUES ('$userid', '$roomid');";
    $result = mysqli_query($conn, $sql);
}
header('Location: home1.php');


?>
