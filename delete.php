<?php
//Start session
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("Location: login.html");
}

if (!$_SESSION['admin']){
    header("Location: home.php"); // check this
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

if(isset($_GET['roomid'])){
    $roomid=$_GET['roomid'];
    $sql = "UPDATE room SET Deleted=TRUE WHERE RoomID=$roomid;";
    $result = mysqli_query($conn, $sql);
}
header('Location: home.php');


?>
