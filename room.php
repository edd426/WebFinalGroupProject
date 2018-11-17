<?php
//Start session
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("Location: login.html");
}

if (!isset($_SESSION['admin'])){
    header("Location: home.php"); // check this
}

?>

<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="signup.css" type="text/css" rel="stylesheet">
    <script src="jquery-3.3.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?php

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

$roomname='';
$occupancy='';
$roomid='';
$roomfeatureids = array();
$roomfeaturenames = array();

//if roomid is set, this might be an update page
if(isset($_GET['roomid'])){
    $roomid=$_GET['roomid'];
    $sql = "SELECT * FROM room WHERE RoomID=$roomid;";
    $result = mysqli_query($conn, $sql);

    // if RoomID doesn't exist, redirect to home page
    if(mysqli_num_rows($result)==0){ 
        header("location: home.php");
    }
    // Get Name and occupancy
    $row = mysqli_fetch_array($result);
    $roomname=$row['Name'];
    $occupancy=$row['Occupancy'];

    // Get List of room Feature ID's
    $sql = "SELECT FeatureID FROM room_feature WHERE RoomID=$roomid;";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result))
        $roomfeatureids[] = $row['FeatureID'];
}

// Get list of all room features names!
$sql = "SELECT * FROM feature;";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
    $roomfeaturenames[$row['FeatureID']] = $row['FName'];

// insert the form below
?>
    <h3>Add/Update A Room</h3>
    <form action='' method='POST' enctype='multipart/form-data'>
        <div class="form-row">
            <div class="col-4">
                Room Name
                <input type="text" class ="form-control" id="RoomName" name="roomname" placeholder="Room Name" value="<?php echo $roomname; ?>" novalidate> 
            </div>
        </div>
        <div class="form-row">
            <div class="col-4">
                Room Occupancy
                <input type="text" class="form-control" id="Occupancy" name="roomoccupancy" value="<?php echo $occupancy; ?>"  placeholder="Occupancy">
            </div>
        </div>
        <div class="form-row">
            <div class="col-4">
            Features
            <?php
            for ($i=0; $i<10; $i++){
                $myfeature = ($i < count($roomfeatureids)) ? $roomfeaturenames[$roomfeatureids[$i]] : '';
                echo "<input type='text' class='form-control' name='id[$i]' value='$myfeature'  placeholder='Feature'>";
            }
            ?>
            </div>
        </div>

        <div class="form-row">
            <div class="col-4">
                Room Picture
                <input type='file' name='userFile'><br>
            </div>
        </div>
        <div class="form-row">
            <div class="col-4">
                <button type="submit" class="btn btn-primary" value='upload'>Submit</button>
                </br>
            </div>
        </div>
    </form>
</body>
</html>

<?php
// Get info from form
//
// Get the image
$info = pathinfo($_FILES['userFile']['name']);
$ext = $info['extension']; // get the extension of the file

// Get the room info
$newname = $_POST['roomname'];
$newoccupancy = $_POST['roomoccupancy'];
$newfeatures = $_POST['id'];

// If not empty, continue on to update

if($newname!='' && $newoccupancy!='' && is_uploaded_file($_FILES['userFile']['tmp_name'])){

    // Insert features that aren't in database
    $sql = "INSERT INTO feature (FName) VALUES ";
    foreach($newfeatures as $mynewf){
        if($mynewf != '' && !in_array($mynewf, $roomfeaturenames))
            $sql.="('$mynewf'), ";
    }
    $sql=substr($sql, 0, strlen($sql)-2).";";
    $result = mysqli_query($conn, $sql);
    
    // Refresh list of all room features names!
    $sql = "SELECT * FROM feature;";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result))
        $roomfeaturenames[$row['FeatureID']] = $row['FName'];

    //Either update or add a new room
    if(isset($_GET['roomid'])){
        // Update existing room
        $sql = "UPDATE room SET Name='$newname', Occupancy='$newoccupancy' VALUES WHERE room.RoomID='$roomid';";
        $result = mysqli_query($conn, $sql);

        $newimg = $_GET['roomid'].".".$ext;
    }else{
        // Insert new room
        $sql = "INSERT INTO room (Name, Occupancy) VALUES ('$newname', '$newoccupancy');";
        $result = mysqli_query($conn, $sql);
        // Get new roomid
        $sql = "SELECT room.RoomID FROM room WHERE room.Name='$newname';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $roomid = $row['RoomID'];

        // Name picture
        $newimg = $row['RoomID'].".".$ext;
        }

    // Attach features to new room
    $sql = "INSERT INTO room_feature (RoomID, FeatureID) VALUES ";
    foreach($newfeatures as $mynewf){
        if($mynewf != '' && !in_array(array_search($mynewf, $roomfeaturenames), $roomfeatureids) ){
            $mynewfid = array_search($mynewf, $roomfeaturenames);
            $sql.="('$roomid', '$mynewfid'), ";
        }
    }
    $sql=substr($sql, 0, strlen($sql)-2).";";
    $result = mysqli_query($conn, $sql);

    // Save uploaded image to Images/ folder w/ roomid as name.
    $imagepath = "Images/".$newimg;
    move_uploaded_file( $_FILES['userFile']['tmp_name'], $imagepath);

    mysqli_close();
    header("location: home.php");
}

mysqli_close();
?>

