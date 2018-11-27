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

    $sql = "DELETE FROM favorite WHERE UserID='$userid' AND RoomID='$roomid';";
    $result = mysqli_query($conn, $sql);
}
header('Location: user.php');


?>
