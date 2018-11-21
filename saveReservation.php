<?php
$RoomID = $_GET["roomID"];
$UserID = $_GET["userID"];
$StartTime = $_GET["startTime"];
$EndTime = $_GET["endTime"];
$ResDate = $_GET["resDate"];


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

$sql = "INSERT INTO reservation (RoomID, UserID, StartTime, EndTime, ResDate) VALUES 
('".$RoomID."', '".$UserID."', '".$StartTime."', '".$EndTime."', '".$ResDate."')";

if ($conn->query($sql) === TRUE) 
{
    mysqli_close($conn);
    echo "New record created successfully";
    header('Location: '.'../home.php');
} else 
{
    mysqli_close($conn);
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
?>