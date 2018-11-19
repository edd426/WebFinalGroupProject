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

//Pagination Code below
//Control number of pages w/ rec_limit
$rec_limit = 6;

/* Get total number of records */
$sql = "SELECT count(RoomID) FROM room WHERE Deleted=FALSE;";
$retval = mysqli_query($conn, $sql);


if(! $retval ) {
    die('Could not get data: ' . mysql_error());
}
$row = mysqli_fetch_array($retval);
$rec_count = $row[0];

if( isset($_GET{'page'} ) ) {
    $page = $_GET{'page'} + 1;
    $offset = $rec_limit * $page ;
}else {
    $page = 0;
    $offset = 0;
}

$left_rec = $rec_count - ($page * $rec_limit);

// Post pagination
if( $page > 0 ) {
    $last = $page - 2;
    echo "<a href = \"$_PHP_SELF?page=$last\">Last $rec_limit Records</a> |";
    echo "<a href = \"$_PHP_SELF?page=$page\">Next $rec_limit Records</a>";
}else if( $page == 0 ) {
    echo "<a href = \"$_PHP_SELF?page=$page\">Next $rec_limit Records</a>";
}else if( $left_rec < $rec_limit ) {
    $last = $page - 2;
    echo "<a href = \"$_PHP_SELF?page=$last\">Last $rec_limit Records</a>";
}


$sql = "SELECT * FROM room WHERE Deleted=FALSE LIMIT $offset, $rec_limit;";

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
    <a href = 'ReserveRoom.php?roomid=".$row["RoomID"]."'>Reserve This Room</a><br>";
    if($_SESSION['admin']==TRUE){
        echo "<a href = 'room.php?roomid=".$row["RoomID"]."'>Update This Room</a><br>";
        echo "<a href = 'delete.php?roomid=".$row["RoomID"]."'>Delete This Room</a>";
    }
    echo "</div></div></div>";
}

// Pagination again
if( $page > 0 ) {
    $last = $page - 2;
    echo "<a href = \"$_PHP_SELF?page=$last\">Last $rec_limit Records</a> |";
    echo "<a href = \"$_PHP_SELF?page=$page\">Next $rec_limit Records</a>";
}else if( $page == 0 ) {
    echo "<a href = \"$_PHP_SELF?page=$page\">Next $rec_limit Records</a>";
}else if( $left_rec < $rec_limit ) {
    $last = $page - 2;
    echo "<a href = \"$_PHP_SELF?page=$last\">Last $rec_limit Records</a>";
}

?>

</body>
</html>
