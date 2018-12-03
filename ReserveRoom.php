<?php
session_start();

if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("location: login.php");
}
?>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="home.css" type="text/css" rel="stylesheet"></link>
  <link href="reserveRoom.css" type="text/css" rel="stylesheet"></link>
  <script type="text/javascript" src="/FinalProject/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="/FinalProject/ReserveRoom.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A3E4C;">
  <a class="navbar-brand" href="home1.php">Meeting Master</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="home1.php">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="user.php">My Page</a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
    </div>
  </div>
</nav>
<div class = "reservation">
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
  <div class = "row"><img class="img-thumbnail" src = "Images/<?php echo $roomID;?>.jpg"></img></br>
  </div>
    <form id = "reservationForm">
      <div class = "form-row">
        <div class = "col-3">
          Select a date <input class= "form-control" id="MeetingDate" type='date' min='2018-01-01' value = "" size = "10"></input>
        </div>
      </div>
  <div class = "form-row">
    <div class = "col-6" id = "schedule">
    </div>
  </div>
  <div class = "form-row">
    <input id = "submit" class="btn btn-primary" type = "submit" value = "Save Reservation" disabled></input>
    <input type = "button" class="btn btn-danger" value = "Cancel" onClick = "window.location.href = 'home1.php'"></button>
  </div>
  <div class = "form-row">
    <p id ="errorMessage"></p>
  </div>
  </form>
</div>
</body>
</html>