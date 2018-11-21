<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
  <link href="../home.css" type="text/css" rel="stylesheet"></link>
  <link href="../reserveRoom.css" type="text/css" rel="stylesheet"></link>
  <script type="text/javascript" src="/FinalProject/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="/FinalProject/ReserveRoom.js"></script>
</head>
<body>

<?php
echo "<p id = 'userid' hidden>".$_SESSION["userid"]."</p>";
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
<form id = "reservationForm">
    Date: <input class= "form-control" id="MeetingDate" type='date' min='2018-01-01' value = ""></input>


<div id = "schedule">
</div>
<input id = "submit" class="btn btn-primary" type = "submit" value = "Save Reservation" disabled></input>
<input type = "button" class="btn btn-danger" value = "Cancel" onClick = "window.location.href = '../home.php'"></button>
<p id ="errorMessage"></p>

</form>
</body>
</html>