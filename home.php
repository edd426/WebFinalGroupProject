<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="home.css" type="text/css" rel="stylesheet">
</head>
<body>

<?php
//Start session
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("location: login.html");
}

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

$sql = "SELECT * FROM room WHERE Deleted=FALSE;";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result))
{
    echo "<div class='panel panel-default'>
            <div class='panel-heading'>".$row["Name"]."</div>
            <div class='panel-body'><img src='Images/".$row["RoomID"].".jpg' alt='Room".$row["RoomID"]."' width='200'><div>Occupancy: ".$row["Occupancy"]."</br>Features:</br><ul>";
    
    $sql = "SELECT * FROM room_feature WHERE RoomID LIKE ".$row["RoomID"].";";
    $result1 = mysqli_query($conn, $sql);

    while($row1 = mysqli_fetch_array($result1))
    {
        $sql = "SELECT * FROM feature WHERE FeatureID LIKE ". $row1["FeatureID"].";";
        $result2 = mysqli_query($conn, $sql);
        while($row2 = mysqli_fetch_array($result2))
        {
            echo "<li>".$row2["FName"]."</li>";
        }
    }            
            
            
    echo "</ul></br>
    <a href = 'ReserveRoom.php/?roomid=".$row["RoomID"]."'>Reserve This Room</a></div></div>
    </div>";
}


?>

</body>
</html>
