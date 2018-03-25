 <?php
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	$SEARCH = $_GET['search'];
	$SEARCHVALUE = $_POST['searchvalue'];
	$SEARCHFIELD = $_POST['searchfield'];
	
	//Search Query
	if($SEARCH == "myprojects"){
		$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$UNAME'"); //query for own projects view
	} else if(isset($SEARCHFIELD) && isset($SEARCHVALUE)){
		$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE LOWER($SEARCHFIELD) LIKE LOWER('%$SEARCHVALUE%')"); //query for search
	} else {
		$result = pg_query($db, "SELECT * FROM projectsOwnership"); //query for all projects - default view
	}
	
	//$result = pg_query($db, "SELECT * FROM projectsOwnership");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}

	$projects = pg_fetch_all($result);
	$x = 0;
	$table_contents = NULL;
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
		
		//Caclucate the progres bar %
		$bar = $progress / $amount;
		
		//Generate HTML code for each project
		$table_contents .= "<div class='w3-panel w3-pale-green w3-leftbar w3-border-green'>";
		$table_contents .= "<h3><b>" . $name . "</b></h3>";
		$table_contents .= "<p>Amount Raised: " . $progress . "</p>";
		$table_contents .= "<div class='w3-light-grey w3-quarter'><div class='w3-green' style='height:24px;width:" . $bar . "%'></div></div><br>";
		$table_contents .= "<p>" . $description. "</p>";
		$table_contents .= "<a href='?detail=" . $id . $ownerName . "' class='w3-button w3-green'>Go to Project</a>";
		$table_contents .= "<p class='w3-right'>" . $category . "</p>";
		$table_contents .= "</div>";
	}
	
	if(isset($_GET['detail'])){
		$link=$_GET['detail'];
		if(!empty($link)){
			//set session variables for project id and project name..acts as a global variable?
			$pid = preg_replace('/\D/', '', $link); //retrieve pid
			$pname = preg_replace('/[0-9]+/', '', $link); //retrieve pname
			$_SESSION['PID']=$pid;
			$_SESSION['PNAME']=$pname;
			header("Location: detailedproj.php");
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
<div class="w3-row">
  <div class="w3-col m3 w3-center"><p></p></div>
  <div class="w3-col m6 w3-center"><p></p>
  	<form class="w3-container w3-center" action="index.php" method="POST">
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
  </div>
  <div class="w3-col m3 w3-center"><p></p></div>
</div>

<div class="w3-container">
	<?php
	echo $table_contents;
	?>
</div>
  
<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
