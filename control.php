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
	$result = pg_query($db, "SELECT username FROM users WHERE uid=$UID");
	$userRow = pg_fetch_assoc($result);

	//Display user ID
	echo "<h2>Welcome user $UNAME</h2>";
    ?> 

  <ul>
    <form name="display" action="create.php" method="POST" >
      <li><input type="submit" value="Create Project" /></li>
    </form>
  </ul>

  <ul>
    <form name="display" action="browse.php" method="POST" >
      <li><input type="submit" value="Browse all projects" /></li>
    </form>
  </ul>
   
</body>
</html>
