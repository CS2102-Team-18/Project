<?php
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$PID = $_SESSION['PID'];
	$PNAME = $_SESSION['PNAME'];
	$OWNPROJECT = $_SESSION['OWNPROJECT'];

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	//Display selected project based on $PID and $PNAME
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$PNAME' AND projectid = '$PID'");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}
	/* debugging
	echo "<br><br><br>HELLO"; //testing
	echo "<br>";
	echo "$PID";
	echo "<br>";
	echo "$PNAME";
	echo "<br>debugging----ignore above this line";

	echo "<br>";
	*/
	$arr = pg_fetch_all($result);

	foreach ($arr as $value){
		$arr2 = array_values($value);
		$projname = $arr2[0];
		$projdesc = $arr2[1];
		$projSDate = $arr2[2];
		$projEDate = $arr2[3];
		$projamount = $arr2[6];
		$projprogress = $arr2[7];
		$projcat = $arr2[8];
	}
	
	//logging out
	if(isset($_GET['logout'])){
		$link=$_GET['logout'];
		if ($link == 'true'){
			header("Location: logout.php");
			exit;
		}
	}	
	
?> 

<!DOCTYPE html>  
<html>
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!-- Import CSS Files -->
  <link rel="stylesheet" href="css/w3.css">
  
</head>

<body>
<!-- Nagivation Bar -->
<?php
if($UNAME == NULL){
	$menu = file_get_contents('menu.html');
	echo $menu;
}
else{
	$menu = file_get_contents('menu-loggedin.html');
	echo $menu;
}
?>

<!-- Slide Show
<div class="w3-content w3-section" style="max-height:500px">
  <img class="mySlides" src="img/water.jpg" style="width:100%">
  <img class="mySlides" src="img/castle.jpg" style="width:100%">
  <img class="mySlides" src="img/road.jpg" style="width:100%">
</div>
-->

<!-- Main Body -->
<?php
if(!is_null($OWNPROJECT)){
	echo "
	<form class='w3-container' action='editproj.php' method='POST'>
    <p>      
    <label class='w3-text-brown'><b>Project Name</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projname</label></p>

    <p>      
    <label class='w3-text-brown'><b>Project Description</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projdesc</label></p>

	<p>      
    <label class='w3-text-brown'><b>Start Date</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projSDate</label></p>

	<p>      
    <label class='w3-text-brown'><b>End Date</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projEDate</label></p>

	<p>      
    <label class='w3-text-brown'><b>Target Amount</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>lel</label></p>

	<p>      
    <label class='w3-text-brown'><b>Progress</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projprogress</label></p>

	<p>      
    <label class='w3-text-brown'><b>Category</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projcat</label></p>
	
    <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit Project Information..pagenotdone'></button></p>
	</form>";
}
?>

<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
