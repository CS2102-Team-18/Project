 <?php
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

	if (isset($_POST['search'])) {
	  $_SESSION['SEARCHVALUE'] = $_POST['searchvalue'];
	  $_SESSION['SEARCHFIELD'] = $_POST['searchfield'];
	  header("Location: searchProj.php");
	  exit;
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
<!-- Navigation Bar -->
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
<form class="w3-container" action="browse.php" method="POST">
	<p>
	<input class="w3-input w3-border w3-sand" name="searchvalue" type="text"></p>
	<label class="w3-text-brown"><b>Search Under:</b></label>
    <select name="searchfield">
		<option value="projectname">Project Name</option>
		<option value="projectdescription">Project Description</option>
		<option value="category">Project Category</option>
    </select>
    <input class="w3-btn w3-brown" type="submit" name="search" value="Search"></button>
</form>
  
<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
