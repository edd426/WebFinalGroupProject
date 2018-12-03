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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="home.css" type="text/css" rel="stylesheet">
  <script src="jquery-3.3.1.js"></script>
  <script src="home.js"></script>
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
<div class="row">
    <div class="col-2">
    <h4>Filters</h4>
    <form id = "filters">
        <div class="form-group">
        <label for="roomSize">Occupancy</label>
        <select name = "roomSize" id="roomSize" class="form-control">
            <option value = ""></option>
            <option value = "1">Less than 5</option>
            <option value = "2">5-10</option>
            <option value = "3">11-20</option>
            <option value = "4">More than 20</option>
         </select>
        </div>
        <div class="form-group">
            <label for="features">Features</label>
            <select name = "features[]" id = "features" multiple class="form-control">
                    <option value = "1">1</option>
                    <option value = "2">2</option>
                    <option value = "3">3</option>
                    <option value = "4">4</option>
                    <option value = "5">5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="search">Search</label>
            <input name = "search" class="form-control" type="search" id="search">
        </div>
        <button class="btn btn-primary" type="submit">Filter</button>
        <a class="btn btn-secondary" href="home1.php" role="button">Clear</a>
    </form>
    </div>
    <div id = "rooms" class = "col-10">
    </div>
    
    </div>
    </body>
    </html>