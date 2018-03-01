<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
  <style>p.indent{ padding-left: 1.8em }</style>
</head>
<body>
  <h2>Create a Project</h2>
  <ul>
    <form name="display" action="create.php" method="POST" >
      <li>Project Name:</li>
      <li><input type="text" name="projName" /></li>
	  <p class="indent"></p>

	  <li>Project Description:</li>
	  <li><input type="text" name="projDesc" /></li>
	  <p class="indent"></p>

	  <li>Start date:</li>
	  <li><input type="date" name="sDate" /></li>
	  <p class="indent"></p>

	  <li>End date:</li>
	  <li><input type="date" name="eDate" /></li>
	  <p class="indent"></p>

	  <li>Target Amount:</li>
	  <li><input type="number" name="targetAmount" /></li>
	  <p class="indent"></p>

	  <li>Category:</li>
	  <li><input type="text" name="category" /></li>
	  <p class="indent"></p>

      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
	
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

  	// Connect to the database. 
    $db     = pg_connect("host=localhost port=5432 dbname=Project1 user=postgres password=wzcs2102");

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
   <ul>
    <form name="display" action="control.php" method="POST" >
      <li><input type="submit" value="Return to control panel" /></li>
    </form>
  </ul>
</body>
</html>
