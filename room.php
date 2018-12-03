<?php
//Start session
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<p>session not set</p>";
    var_dump($_SESSION);
    header("Location: login.html");
}

if (!$_SESSION['admin']){
    header("Location: home1.php"); // check this
}

?>

<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--<link href="signup.css" type="text/css" rel="stylesheet">-->
    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="jquery-3.3.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        header("location: home1.php");
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
        $sql = "UPDATE room SET Name='$newname', Occupancy='$newoccupancy' WHERE room.RoomID='$roomid';";
        $result = mysqli_query($conn, $sql);

        $newimg = $roomid.".".$ext;
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
    header("location: home1.php");
    
}
mysqli_close();


// insert the form below
?>
    <div class='form-row'>
    <div class='col-6'>
    <div class='card'>
    <div class='card-header'>
        <h3>Add/Update A Room</h3>
        <h6>Room Name, Occupancy, and Photo required.</h6>
    </div>
    </div>
    </div>
    </div>
    <form action='' method='POST' enctype='multipart/form-data'>
        <div class="form-row">
            <div class="col-6">
                <div class='card'>
                    <div class='card-header'>
                        Room Name
                    </div>
                    <div class='card-body'>
                        <input type="text" class ="form-control" id="RoomName" name="roomname" placeholder="Name" value="<?php echo $roomname; ?>" novalidate> 
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class='card'>
                    <div class='card-header'>
                        Room Occupancy
                    </div>
                    <div class='card-body'>
                        <input type="text" class="form-control" id="Occupancy" name="roomoccupancy" value="<?php echo $occupancy; ?>"  placeholder="Occupancy">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class='card'>
                    <div class='card-header'>
                        Room Features
                    </div>
                    <div class='card-body'>
                        <?php
                        for ($i=0; $i<10; $i++){
                            $myfeature = ($i < count($roomfeatureids)) ? $roomfeaturenames[$roomfeatureids[$i]] : '';
                            echo "<input type='text' class='form-control' name='id[$i]' value='$myfeature'  placeholder='Feature'>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <div class='card'>
                    <div class='card-header'>
                        Room Photo
                    </div>
                    <div class='card-body'>
                        <input type='file' name='userFile'><br>
                    </div>
                </div>
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

