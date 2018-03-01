<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Enter username and password</h2>
  <ul>
    <form name="display" action="index.php" method="POST" >
      <li>Username:</li>
      <li><input type="text" name="usernameInput" /></li>
	  <li>Password:</li>	  
	  <li><input type="text" name="passwordInput" /></li>
      <li><input type="submit" name="submitLogin" value = "login" /></li>
	  <br></br>
	  <li><input type="submit" name="submitCreate" value = "Create new account" /></li>
    </form>
  </ul>
  <?php
  
  session_start();
  
  $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=167294381");	
  $result = pg_query($db, "SELECT uid FROM users WHERE username = '$_POST[usernameInput]' AND pssword = '$_POST[passwordInput]'");
  if (isset($_POST['submitLogin'])) {
	  $userNameRow = pg_fetch_assoc($result);
	  $userFound = pg_num_rows($result);
	  
	  if ($userFound < 1) {
		  echo "Invalid username/password";
	  }
	  
	 else {
		  $_SESSION['UID'] = $userNameRow[uid];
		  $host = $_SERVER['HTTP_HOST'];
		  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		  $extra = 'crowdfunding.php';
		  header("Location: http://$host$uri/$extra");
		  exit;
	  }
  }
  
  if (isset($_POST['submitCreate'])) {
		  $host = $_SERVER['HTTP_HOST'];
		  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		  $extra = 'createaccount.php';
		  header("Location: http://$host$uri/$extra");
		  exit;
	  }
	
    ?>  
	
</body>
</html>
