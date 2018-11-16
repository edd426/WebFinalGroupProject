<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?

//Start session
//session_start();
$admin = $_SESSION['Admin']; // check this
//$semail = $_SESSION['Email'];
//$suserid = $_SESSION['UserID'];
if(!isset($_SESSION['username'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    $admin = true;
    //header("location: login.html");
    //$semail = 'JohnSmith@address.com';
    //$suserid = 1;
}

if (!$admin){
    header('http://localhost:81/WebFinalGroupProject/index.php'); // check this
}

echo "<h1>Add/Update A Room</h1>";

$dbuser = 'root';
$dbpass = 'root';
$db = 'test';
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
    $roomUp=$_GET['roomid'];
    $sql = "SELECT * FROM room WHERE ReomID=$roomUp;";
    $result = mysqli_query($conn, $sql);
}
echo "<>"

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
echo "<h4>Your current reservations</h4>";
echo "<table class='table table-striped'><tr><th>Start Time</th><th>End Time</th><th>Reservation Date</th><th>Room Name</th><th></th></tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr><td>". $timeArr[$row["StartTime"]] ."</td><td>". 
        $timeArr[$row["EndTime"]]."</td><td>". $row["ResDate"].
        "</td><td>". $row["Name"].
        "</td><td><a href='http://localhost:81/WebFinalGroupProject/".
        "user.php?deleteRes=".$row["ResID"]."'>Delete</a></td></tr>";
}
echo "</table>";


//Show Past Reservations
$sql = "SELECT StartTime, EndTime, ResDate, room.Name ".
    "FROM user, reservation, room ".
    "WHERE user.UserID=reservation.UserID AND user.UserID='$suserid' ".
    "AND reservation.roomID=room.RoomID AND reservation.ResDate<CURDATE();";
$result = mysqli_query($conn, $sql);
//echo $result;
echo "<h4>Your past reservations</h4>";
echo "<table class='table table-striped'><tr><th>Start Time</th><th>End Time</th><th>Reservation Date</th></tr>";

while($row = mysqli_fetch_array($result)){
	echo "<tr><td>". $timeArr[$row["StartTime"]] ."</td><td>". $timeArr[$row["EndTime"]]."</td><td>". $row["ResDate"]."</td><td>". $row["Name"]."</td></tr>";
}
echo "</table>";


//Show Favorite Reservations
$sql = "SELECT room.Name FROM user, favorite, room ".
    "WHERE user.UserID=favorite.UserID AND user.UserID='$suserid' ".
    "AND room.RoomID=favorite.RoomID AND NOT room.Deleted;";
$result = mysqli_query($conn, $sql);
//echo $result;
echo "<h4>Your favorite rooms</h4>";
echo "<table class='table table-striped'><tr><th>Room Name</th><th></th></tr>";

while($row = mysqli_fetch_array($result)){
	echo "<tr><td>". $row["Name"] ."</td><td><a href=''>Reserve</a></td></tr>";
}
echo "</table>";


//echo "<p><a href=logout.php>Logout</a></p>";
mysqli_close();
session_write_close();

?>

</body>
</html>
