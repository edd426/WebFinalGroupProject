<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="home.css" type="text/css" rel="stylesheet">
  <script src="ReserveRoom.js"></script>
</head>
<body>

<?php
$roomID = $_GET["roomid"];

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

$sql = "SELECT * FROM room WHERE RoomID LIKE ".$roomID;

$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
    echo "<h1>".$row["Name"]."</h1>";
}
?>
<form>
    Date: <input class= "form-control" id="MeetingDate" type='date' min='2018-01-01' value = ""></input>
</form>

</body>
</html>