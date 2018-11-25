<?php
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

$sql = "SELECT * FROM feature";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){

    echo "<option value = '".$row['FeatureID']."'>".$row['FName']."</option>";

}   
?>