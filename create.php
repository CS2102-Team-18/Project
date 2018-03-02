<?php
	
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	// Obtain current project number of user
	$result = pg_query($db, "SELECT MAX(projectid) AS max FROM projectsOwnership WHERE ownername = '$UNAME'");
	if(!$result){
		echo "query1 fail \n";
	}
	$projIdNum = pg_fetch_assoc($result);
	$idNumRows = pg_num_rows($result);
	if ($idNumRows < 1) {
		$idNum = 1;
	} else {
		$idNum = $projIdNum[max] + 1;
	}

	// Run the query to create a project
	if (isset($_POST['submit'])) {
		$sql = "INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category)
values ('$_POST[projName]', '$_POST[projDesc]', date '$_POST[sDate]', date '$_POST[eDate]', '$idNum', '$UNAME', $_POST[targetAmount], 0, '$_POST[category]')";
		$aresult = pg_query($db, $sql);
		if (!$aresult) {
			echo "An error occurred\n";
			echo "<br>";
			echo "$_POST[eDate]";
			echo "<br>";
			echo "$_POST[targetAmount]";
		} else {
			echo "Create project successful\n";
		}
	}

?> 

<!DOCTYPE html>  
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

<!-- Create Project Form -->
<div class="w3-card-4">
  <div class="w3-container w3-brown">
    <h2>Create a Project</h2>
  </div>
  <form class="w3-container" action="create.php" method="POST">
    <p>      
    <label class="w3-text-brown"><b>Project Name</b></label>
    <input class="w3-input w3-border w3-sand" name="projName" type="text"></p>
    <p>      
    <label class="w3-text-brown"><b>Project Description</b></label>
    <input class="w3-input w3-border w3-sand" name="projDesc" type="text"></p>
	<p>      
    <label class="w3-text-brown"><b>Start Date</b></label>
    <input class="w3-input w3-border w3-sand" name="sDate" type="date"></p>
	<p>      
    <label class="w3-text-brown"><b>End Date</b></label>
    <input class="w3-input w3-border w3-sand" name="eDate" type="date"></p>
	<p>      
    <label class="w3-text-brown"><b>Target Amount</b></label>
    <input class="w3-input w3-border w3-sand" name="targetAmount" type="text"></p>
	<p>      
    <label class="w3-text-brown"><b>Category</b></label>
    <input class="w3-input w3-border w3-sand" name="category" type="text"></p>
    <input class="w3-btn w3-brown" type="submit" name="submit" value="Create Project"></button></p>
  </form>
</div>
</body>
</html>
