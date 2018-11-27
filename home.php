<?php
//Start session
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("location: login.html");
}

$page = $_GET["page"];
$features = $_GET["features"];
$roomSize = $_GET["roomSize"];
$search = $_GET["search"];

if(empty($page))
{
    $page=0;
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
//Control number of pages w/ room_limit
$room_limit = 5;

/* Get total number of rooms */
$sql = "SELECT count(RoomID) FROM room WHERE Deleted=FALSE";

$retval = mysqli_query($conn, $sql);


if(! $retval ) {
    die('Could not get data: ' . mysql_error());
}
$row = mysqli_fetch_array($retval);
$room_count = $row[0];
   

$room_ids1 = array();
$sql = "SELECT * FROM room WHERE Deleted=FALSE";

if(!empty($roomSize))
{
    switch($roomSize)
    {
        case 1:
            $sql = $sql." AND Occupancy < 5";
            break;
        case 2:
            $sql = $sql." AND Occupancy BETWEEN 5 AND 10";
            break;
        case 3:
            $sql = $sql." AND Occupancy BETWEEN 11 AND 20";
            break;
        case 4:
            $sql = $sql." AND Occupancy > 20";
            break;
    }
}

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result))
{
    array_push($room_ids1, $row["RoomID"]);
}

if(!empty($features[0]))
{
    $room_ids2 = array();
    $sql = "SELECT * FROM room_feature WHERE FeatureID=".$features[0];
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result))
    {
        array_push($room_ids2, $row["RoomID"]);
    }
    for($i = 1; $i < count($features); $i++)
    {
        $temp = array();
        $sql = "SELECT * FROM room_feature WHERE FeatureID=".$features[$i];
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result))
        {
            array_push($temp, $row["RoomID"]);
        }
        $room_ids2 = array_intersect($room_ids2, $temp);
    }
    $room_ids1 = array_intersect($room_ids1, $room_ids2);
}

if(!empty($search))
{
    //Search room names
    $room_ids3 = array();
    $sql = "SELECT * FROM room WHERE Name LIKE '%".$search."%'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result))
    {
        array_push($room_ids3, $row["RoomID"]);
    }

    //Search feature names
    $room_ids4 = array();
    $feature_ids = array();
    $sql = "SELECT * FROM feature WHERE FName LIKE '%".$search."%'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result))
    {
        array_push($feature_ids, $row["FeatureID"]);
    }
    //print_r($feature_ids);
    foreach($feature_ids as $id)
    {
        $sql = "SELECT * FROM room_feature WHERE FeatureID='".$id."'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result))
        {
            array_push($room_ids4, $row["RoomID"]);
        }

    }
    $room_ids4 = array_unique(array_merge($room_ids3, $room_ids4));
    $room_ids1 = array_intersect($room_ids1, $room_ids4);
}


$start = $page * $room_limit;
$end = $start + $room_limit - 1;
$count = 0;

foreach ($room_ids1 as $value)
{
    if($count >= $start and $count <= $end)
    {
        $sql = "SELECT * FROM room WHERE RoomID LIKE ". $value;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        echo "<div class='card'>
                <div class='card-header'>".$row["Name"]."</div>
                <div class='card-body'><img src='Images/".$row["RoomID"].".jpg' alt='Room".$row["RoomID"]."' width='300'><div>Occupancy: ".$row["Occupancy"]."</br>Features:</br><ul>";
    
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
            
            
        echo "</ul></br>";
        echo "<a href = 'ReserveRoom.php?roomid=".$row["RoomID"]."'>Reserve This Room</a><br>";
        echo "<a href = 'addfavorite.php?roomid=".$row["RoomID"]."'>Favorite This Room</a><br>";
        if($_SESSION['admin']==TRUE){
            echo "<a href = 'room.php?roomid=".$row["RoomID"]."'>Update This Room</a><br>";
            echo "<a href = 'delete.php?roomid=".$row["RoomID"]."'>Delete This Room</a>";
        }
        echo "</div></div></div>";
    }   
    $count++;
}

$page_count = ceil(sizeof($room_ids1)/$room_limit);
//echo $page_count;
echo "<nav aria-label='Page navigation example'>
                    <ul class='pagination'>
                        <li class='page-item";
if($page == 0)
{
    echo " disabled";
}
                        echo "'>
                            <a class='page-link' href='";
if($page>0)
{
    $url = $_SERVER['REQUEST_URI'];     
    if(strpos($url, "&page=") !== false)
    {
        $url = explode("&page=", $url)[0];
    }     
    $url = "home1.php?".explode("?", $url)[1]."&page=".($page-1);
    echo $url;
} 
echo "' aria-label='Previous'>
        <span aria-hidden='true'>&laquo;</span>
        <span class='sr-only'>Previous</span>
         </a>
        </li>";
for($j = 0; $j < $page_count; $j++)
{
    echo "<li class='page-item'><a class='page-link' href='";
    $url = $_SERVER['REQUEST_URI'];
    if(strpos($url, "&page=") !== false)
    {
        $url = explode("&page=", $url)[0];
    }
    $url = "home1.php?".explode("?", $url)[1]."&page=".$j;
    echo $url;
    echo "'>";
    echo $j+1;
    echo "</a></li>";
}

echo "<li class='page-item";

if($page == $page_count-1)
{
    echo " disabled";
}

echo "'>
        <a class='page-link' href='";

if($page<$page_count-1)
{
    $url = $_SERVER['REQUEST_URI'];     
    if(strpos($url, "&page=") !== false)
    {
        $url = explode("&page=", $url)[0];
    }     
    $url = "home1.php?".explode("?", $url)[1]."&page=".($page+1);
    echo $url;
} 
        echo"' aria-label='Next'>
            <span aria-hidden='true'>&raquo;</span>
            <span class='sr-only'>Next</span>
        </a>
        </li>
        </ul>
        </nav>";
?>
