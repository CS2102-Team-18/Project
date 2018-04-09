<?php
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$PID = $_SESSION['PID'];
	$PNAME = $_SESSION['PNAME'];

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	//Display selected project based on $PID and $PNAME
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$PNAME' AND projectid = '$PID'");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}

	$projects = pg_fetch_all($result);

	foreach ($projects as $project){
		$row = array_values($project);
		$name = $row[0];
		$description = $row[1];
		$startDate = $row[2];
		$endDate = $row[3];
		$id = $row[4];
		$ownerName = $row[5];
		$amount = $row[6];
		$progress = $row[7];
		$category = $row[8];
		$status = $row[9];
		
		//Caclucate the progres bar %
		$bar = floor(($progress / $amount) * 100);
		if ($bar > 100){
			$bar = 100;
		}

	}

	//contribute to project
	if(isset($_POST['pay'])){
		header("Location: pay.php");
	}

	if (isset($_POST['finish'])) {
		$result = pg_query($db, "UPDATE projectsOwnership SET projectStatus = 'COMPLETED' WHERE projectID = '$PID' AND ownerName = '$PNAME'");
		if(!$result){
			echo "<br>Error updating project status to completed.<br>";
		}
		header("Location: detailedproj.php");
	}

	if (isset($_POST['halt'])) {
		$result = pg_query($db, "UPDATE projectsOwnership SET projectStatus = 'HALTED' WHERE projectID = '$PID' AND ownerName = '$PNAME'");
		if(!$result){
			echo "<br>Error updating project status to halted.<br>";
		}
		header("Location: detailedproj.php");
	}	

	if (isset($_POST['resume'])) {
		$result = pg_query($db, "UPDATE projectsOwnership SET projectStatus = 'ACTIVE' WHERE projectID = '$PID' AND ownerName = '$PNAME'");
		if(!$result){
			echo "<br>Error updating project status to resume.<br>";
		}		
		header("Location: detailedproj.php");
		
		if(isset($_GET['detail'])){
			$link=$_GET['detail'];
			if(!empty($link)){
				//set session variables for project id and project name..acts as a global variable?
				$userid = preg_replace('/\D/', '', $link); //retrieve userID
				$username = preg_replace('/[0-9]+/', '', $link); //retrieve userName
				$_SESSION['CUID']=$userid;
				$_SESSION['CUNAME']=$username;
				header("Location: edituser.php");
			}
		}
	}

	if (isset($_POST['delete'])) {
		$result = pg_query($db, "UPDATE projectsOwnership SET projectStatus = 'DELETED' WHERE projectID = '$PID' AND ownerName = '$PNAME'");
		if(!$result){
			echo "<br>Error deleting project from database<br>";
		}
		header("Location: detailedproj.php");
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
	if($_SESSION['ADMIN'] == "true"){
		$menu = file_get_contents('menu-admin.html');
	} else {
		$menu = file_get_contents('menu-loggedin.html');
	}
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
<div class='w3-row'>
	<div class='w3-col m8 w3-card w3-margin w3-left'>
		<header class="w3-container w3-brown">
		  <h1><?php echo $name;?></h1>
		</header>

		<div class="w3-container w3-sand">
			<p><b>Project Status: </b><?php echo $status;?></p>
			<p><b>Project ends at: </b><?php echo $endDate;?></p>
			<p><b>Project Description: </b></br><?php echo $description;?></p>
			<p><b>Category: </b><?php echo $category;?></p>
			<?php

			if($status == "COMPLETED"){
				//do nothing
			}
			else if($UNAME == $ownerName){
				echo "<a href='editproj.php' class='w3-button w3-brown'>Edit Project Information</a></br></br>";
			}
			else{
				if ($_SESSION['ADMIN'] == "true"){
					echo "<a href='pay.php' class='w3-button w3-brown w3-margin-right'>Fund this Project</a>";
					echo "<a href='editproj.php' class='w3-button w3-brown'>Edit Project Information</a></br></br>";
				}
				else {
					echo "<a href='pay.php' class='w3-button w3-brown'>Fund this Project</a></br></br>";
				}
			}
			?>
		</div>

		<footer class="w3-container w3-brown">
		  <h6>Project Creator: <?php echo $ownerName;?></h6>
		</footer>
	</div>
	<div class="w3-col m3 w3-card w3-margin w3-right">
		<header class="w3-container w3-brown">
			<p>Amount Raised: <?php echo $progress . " of " . $amount;?></p>
		</header>
		
		<div class="w3-light-grey">
			<div class='w3-green' style='height:24px;width:<?php echo $bar;?>%'></div>
		</div>			
	</div>

	<div class="w3-col m3 w3-right w3-container w3-card w3-margin w3-sand">
	<form method="POST">
	<?php
	if($UNAME == $ownerName || $_SESSION['ADMIN'] == true) {
		echo "<header class='w3-brown w3-container'><p>Edit Project Controls</p></header>";
		if($status == "ACTIVE") {
			echo "<p><input class='w3-btn w3-brown' type='submit' name='finish' value='Mark Project as Completed'></p>
				  <p><input class='w3-btn w3-brown' type='submit' name='halt' value='Halt Project'></p>
				  <p><input class='w3-btn w3-brown' type='submit' name='delete' value='Delete Project'></p>";

		} else if($status == "HALTED") {
			echo "<p><input class='w3-btn w3-brown' type='submit' name='finish' value='Mark Project as Completed'></p>
				  <p><input class='w3-btn w3-brown' type='submit' name='resume' value='Resume Project'></p>
				  <p><input class='w3-btn w3-brown' type='submit' name='delete' value='Delete Project'></p>";			
		} else {
			echo "<p><input class='w3-btn w3-brown' type='submit' name='delete' value='Delete Project'></p>";			
		}
		
	}
	?>
		</div>		
	</div>
</div>

<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>