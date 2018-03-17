<?php
session_start();

$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

if($UNAME != NULL){
	header("Location: profile.php");
	die();
}

// Connect to the database. Please change the password in the following line accordingly
include 'db.php';
$db = init_db();

$result = pg_query($db, "SELECT uid FROM users WHERE username = '$_POST[username]' AND pssword = '$_POST[userpass]'");


if (isset($_POST['submit'])) {
	$userRow = pg_fetch_assoc($result);
	$userFound = pg_num_rows($result);
	if ($userFound < 1) {
		echo "no rows found\n";
	} else {
		$_SESSION['UID'] = $userRow[uid];
		$_SESSION['UNAME'] = $_POST[username];
		$_SESSION['OWNPROJECT'] = NULL;
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'profile.php';
		header("Location: http://$host$uri/$extra");
		exit;
		//echo "found matching user with UID = $userRow[uid]";
	}
}

if (isset($_POST['submitCreate'])) {
	  $host = $_SERVER['HTTP_HOST'];
	  $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	  $extra = 'register.php';
	  header("Location: http://$host$uri/$extra");
	  exit;
  }
?>
  
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


<!-- Login Form -->
<div class="w3-card-4">
  <div class="w3-container w3-brown">
    <h2>Login Form</h2>
  </div>
  <form class="w3-container" action="login.php" method="POST">
    <p>      
    <label class="w3-text-brown"><b>Username</b></label>
    <input class="w3-input w3-border w3-sand" name="username" type="text"></p>
    <p>      
    <label class="w3-text-brown"><b>Password</b></label>
    <input class="w3-input w3-border w3-sand" name="userpass" type="password"></p>
    <p>
    <input class="w3-btn w3-brown" type="submit" name="submit" value="Login"></button>
	<input class="w3-btn w3-brown" type="submit" name="submitCreate" value="Register"></button></p>
  </form>
</div>