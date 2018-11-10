<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?

//Start session
session_start();
$semail = $_SESSION['Email'];
$suserid = $_SESSION['UserID'];
if(!isset($_SESSION['username'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    //header("location: login.html");
    $semail = 'JohnSmith@address.com';
    $suserid = 1;
}

echo "<h1>Welcome $semail</h1>";



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

$sql = "SELECT StartTime, EndTime, ResDate FROM user, reservation WHERE user.UserID=reservation.UserID AND user.UserID='$suserid';";

/*
if ($search){
	$sql .= " WHERE BookTitle LIKE '%$search%' ";

}
 */

echo $sql;
$result = mysqli_query($conn, $sql);
//echo $result;
echo "<h4>Your reservations</h4>";
echo "<table class='table table-striped'><tr><th>Book Title</th><th>List Price</th></tr>";

while($row = mysqli_fetch_array($result)){

	echo "<tr><td>". $row["UserID"] ."</td><td>". $row["Email"]."</td></tr>";

}

echo "</table>";
//echo "<p><a href=logout.php>Logout</a></p>";
mysqli_close();
session_write_close();

?>

</body>
</html>
