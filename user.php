<?php
    //Start session
    session_start();
    if(!isset($_SESSION['userid'])) {
        echo "<p>session not set</p>";
        var_dump($_SESSION);
        header("location: login.html");
    }
    $suserid = $_SESSION['userid'];
?>

<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="style.css" type="text/css" rel="stylesheet">
  <script src="jquery-3.3.1.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A3E4C;">
  <a class="navbar-brand" href="#">Meeting Master</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="home1.php">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="user.php">My Page</a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
      <?php 
        if($_SESSION['admin']){
            echo "<a class='nav-item nav-link' href='room.php'>Add Room</a>";
        }
      ?>
    </div>
  </div>
</nav>
<div class='row'>
  <div class='col'>

<?
//Start session
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("location: login.html");
}
$suserid = $_SESSION['userid'];

echo "";
echo "<div class='card'><div class='card-header'><h3>Your Page</h3></div></div><br>";



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


$deleteRes = $_GET["deleteRes"];
if ($deleteRes){
    $sql = "DELETE FROM reservation WHERE ResID=$deleteRes;";
    $result = mysqli_query($conn, $sql);
}

//echo $sql; // DEBUG
$timeArr = array("9:00 AM", "9:30 AM", "10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM", "12:00 PM",
    "12:30 PM", "1:00 PM", "1:30 PM", "2:00 PM", "2:30 PM", "3:00 PM", "3:30 PM", "4:00 PM", "4:30 PM", "5:00 PM");


//Show Current reservations
$sql = "SELECT ResID, StartTime, EndTime, ResDate, room.Name ".
    "FROM user, reservation, room ".
    "WHERE user.UserID=reservation.UserID AND user.UserID='$suserid' ".
    "AND reservation.roomID=room.RoomID AND reservation.ResDate>=CURDATE() ".
    "AND NOT room.Deleted;";
$result = mysqli_query($conn, $sql);
//echo $result;
echo "<div class='card'><div class='card-header'><h4>Your Current Reservations</h4></div>";
echo "<div class='card-body'><table class='table table-striped'><tr><th>Start Time</th><th>End Time</th><th>Reservation Date</th><th>Room Name</th><th></th></tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr><td>". $timeArr[$row["StartTime"]] ."</td><td>". 
        $timeArr[$row["EndTime"]]."</td><td>". $row["ResDate"].
        "</td><td>". $row["Name"].
        "</td><td><a href='http://localhost:81/WebFinalGroupProject/".
        "user.php?deleteRes=".$row["ResID"]."'>Delete</a></td></tr>";
}
echo "</table></div></div>";


//Show Past Reservations
$sql = "SELECT StartTime, EndTime, ResDate, room.Name ".
    "FROM user, reservation, room ".
    "WHERE user.UserID=reservation.UserID AND user.UserID='$suserid' ".
    "AND reservation.roomID=room.RoomID AND reservation.ResDate<CURDATE();";
$result = mysqli_query($conn, $sql);
//echo $result;
echo "<div class='card'><div class='card-header'><h4>Your Past Reservations</h4></div>";
echo "<div class='card-body'><table class='table table-striped'><tr><th>Room Name</th><th>Start Time</th><th>End Time</th><th>Reservation Date</th></tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr><td>". $row["Name"]."</td><td>". $timeArr[$row["StartTime"]] ."</td><td>". 
        $timeArr[$row["EndTime"]]."</td><td>".$row["ResDate"]."</td></tr>";
}
echo "</table></div></div>";


//Show Favorite Reservations
$sql = "SELECT room.RoomID, room.Name FROM user, favorite, room ".
    "WHERE user.UserID=favorite.UserID AND user.UserID='$suserid' ".
    "AND room.RoomID=favorite.RoomID AND NOT room.Deleted;";
$result = mysqli_query($conn, $sql);
//echo $result;
echo "<div class='card'><div class='card-header'><h4>Your Favorite Rooms</h4></div>";
echo "<div class='card-body'><table class='table table-striped'><tr><th>Room Name</th><th>Reserve This Room</th><th>Remove From Favorites</th></tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr><td>". $row["Name"] ."</td><td><a href='ReserveRoom.php?roomid=".
        $row["RoomID"]."'>Reserve</a></td><td><a href='removefav.php?roomid=".
        $row["RoomID"]."'>Remove</a></td></tr>";
}
echo "</table></div></div>";


//echo "<p><a href=logout.php>Logout</a></p>";
mysqli_close();
//session_write_close();

?>

    </div>
</div>
</body>
</html>
