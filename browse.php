<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
  <style>p.indent{ padding-left: 1.8em }</style>
</head>
<body>
  <?php
	
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

  	// Connect to the database. 
    $db     = pg_connect("host=localhost port=5432 dbname=Project1 user=postgres password=wzcs2102");	

	//Display all projects
	echo "<h2>ALL PROJECTS</h2>";
	$result = pg_query($db, "SELECT * FROM projectsOwnership");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}

	$arr = pg_fetch_all($result);
	$x = 0;
	foreach ($arr as $value){
		foreach($value as $value2){
			echo "$value2 ";
			$x++;
			if($x == 9){
				echo "<br>";
				$x = 0;
			}
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
