<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
  <style>p.indent{ padding-left: 1.8em }</style>
</head>
<body>
  <h2>Enter username and password</h2>
  <ul>
    <form name="display" action="index.php" method="POST" >
      <li>Username:</li>
      <li><input type="text" name="username" /></li>
	  <p class="indent"></p>
	  <li>Password:</li>
	  <li><input type="text" name="userpass" /></li>
	  <p class="indent"></p>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
	session_start();

  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=Project1 user=postgres password=wzcs2102");	
    $result = pg_query($db, "SELECT uid FROM users WHERE username = '$_POST[username]' AND pssword = '$_POST[userpass]'");
	
	
	if (isset($_POST['submit'])) {
		$userRow = pg_fetch_assoc($result);
		$userFound = pg_num_rows($result);
		if ($userFound < 1) {
			echo "no rows found\n";
		} else {
			$_SESSION['UID'] = $userRow[uid];
			$_SESSION['UNAME'] = $_POST[username];
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'control.php';
			header("Location: http://$host$uri/$extra");
			exit;
			//echo "found matching user with UID = $userRow[uid]";
		}
	}
    ?> 

</body>
</html>
