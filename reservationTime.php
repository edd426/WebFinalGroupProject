<?php
$date = $_GET["Date"];
$roomID = $_GET["RoomID"];
$taken = array();

for ($x = 0; $x <= 15; $x++) 
{
    array_push($taken, False);
}

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

$sql = "SELECT * FROM reservation WHERE RoomID='".$roomID."' AND ResDate='".$date."'";
$result = mysqli_query($conn, $sql);



while($row = mysqli_fetch_array($result))
{
    $start = $row["StartTime"];
    $end = $row["EndTime"];

    for($y = $start; $y <=$end; $y++)
    {
        $taken[$y] = True;
    }
}
echo "Select time block to reserve room";
echo "<table class='table table-bordered'><tr>
<th>9:00</th>
<th>9:30</th>
<th>10:00</th>
<th>10:30</th>
<th>11:00</th>
<th>11:30</th>
<th>12:00</th>
<th>12:30</th>
<th>1:00</th>
<th>1:30</th>
<th>2:00</th>
<th>2:30</th>
<th>3:00</th>
<th>3:30</th>
<th>4:00</th>
<th>4:30</th></tr><tr>";

for ($z = 0; $z <= 15; $z++) 
{
    if($taken[$z])
    {
        echo "<td class = 'reserved' id = $z></br></td>";
    }
    else
    {
        echo "<td class = 'available' id = $z></br></td>";
    }
}

echo "</tr></table>";
?>