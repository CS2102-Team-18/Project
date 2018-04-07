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

$myinvestmentsflag = 0;
$pastinvestmentsflag = 0;
$totalamountflag = 0;

//Search Query
if($SEARCH == "myprojects"){
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$UNAME' AND projectStatus <> 'DELETED'"); //query for own projects view
} 
else if($SEARCH == "mycompletedprojects"){
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$UNAME' AND projectStatus = 'COMPLETED'"); //query for own completed projects
} 
else if ($SEARCH == "myinvestments") {
	$result = pg_query($db, "SELECT DISTINCT projectid, ownername, amount, projectname, projectdescription, startdate, enddate, targetamount, progress, category FROM investments I NATURAL JOIN projectsownership P WHERE investorname = '$UNAME'" ); 
	$myinvestmentsflag = 1;
}
else if ($SEARCH == "pastinvestments"){
	$result = pg_query($db, "SELECT amount, dateinvested, investmentType, projectID, ownerName, projectName FROM investments I NATURAL JOIN projectsownership P WHERE investorname = '$UNAME' ORDER BY dateinvested desc");
	$pastinvestmentsflag = 1;
}
else if(isset($SEARCHFIELD) && isset($SEARCHVALUE)){
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE (LOWER($SEARCHFIELD) LIKE LOWER('%$SEARCHVALUE%')) AND projectStatus <> 'DELETED'"); //query for search
}
else {
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE projectStatus <> 'DELETED'"); //query for all projects - default view
}

//$result = pg_query($db, "SELECT * FROM projectsOwnership");
//$rows = pg_fetch_assoc($result);

if (!$result) {
	echo "error getting proj from db";
}

if ($myinvestmentsflag == 1) {
	$projects = pg_fetch_all($result);
	$x = 0;
	$table_contents = NULL;
	foreach ($projects as $project){
		$row = array_values($project);
		$id = $row[0];
		$ownerName = $row[1];
		$amount = $row[2];
		$name = $row[3];
		$description = $row[4];
		$startDate = $row[5];
		$endDate = $row[6];
		$targetAmount = $row[7];
		$progress = $row[8];
		$category = $row[9];
		
		//Caclucate the progres bar %
		$bar = floor(($progress / $targetAmount) * 100);
		if ($bar > 100){
			$bar = 100;
		}
		
		// $amountRaised = $progress * $targetAmount;
		
		// $progressPercent = $progress * 100;
		
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
	
// Debug to check if array is correct
//	echo "$pastinvestmentsflag" ;
//	echo "$name" ;
//	echo "amountRaised";
	}
	
	else if ($pastinvestmentsflag == 1) {
	$projects = pg_fetch_all($result);
	$x = 0;
	$table_contents = NULL;
	foreach ($projects as $project){
		$row = array_values($project);
		$amount = $row[0];
		$dateinvested = $row[1];
		$investmentType = $row[2];
		$id = $row[3];
		$ownerName= $row[4];
		$projectName = $row[5];
	
		//Generate HTML code for each project
		$table_contents .= "<div class='w3-panel w3-pale-green w3-leftbar w3-border-green'>";
		$table_contents .= "<h3><b>" . $dateinvested . "</b></h3>";
		$table_contents .= "<p>Project Name: " . $projectName . "</p>";
		$table_contents .= "<p>Owner Name: " . $ownerName . "</p>";
		$table_contents .= "<p>Amount invested: " . $amount . "</p>";
		$table_contents .= "<p>Payment Type: " . $investmentType . "  </p>";
		$table_contents .= "<p><a href='?detail=" . $id . $ownerName . "' class='w3-button w3-green'>Go to Project</a></p>";
		$table_contents .= "</div>";
	}
	
	//echo "$pastinvestmentsflag" ;
	} 
	else {
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
		$bar = floor(($progress / $amount) * 100);
		
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
	if($SEARCH == "myprojects"){
		if(empty($projects)){
			echo "<h3><b>You have no projects!</b></h3>";
		} else {
			echo $table_contents;
		}
	} else {
		echo $table_contents;
	}
	?>
</div>
  
<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
