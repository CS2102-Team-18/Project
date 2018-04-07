<?php
session_start();

//Connect to the database
include 'db.php';
$db = init_db();

//Redirect user to profile page if user is already logged in
$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
if($UNAME != NULL){
	header("Location: profile.php");
	die();
}

$date = date("Y-m-d");	//Current Date
$panelMsg = "";

if (isset($_POST['submit'])) {
$username = $_POST[usernameInput];
$password = $_POST[passwordInput];
$password2 = $_POST[passwordSecondInput];
$passwordLength = strlen($password);

	if ($username == "") {
		$panelMsg = "Please enter a username";
	}
	else if ($password == "") {
		$panelMsg = "Please enter a password";
	}
	else if ($passwordLength < 8) {
		$panelMsg = "Password must have 8 or more characters";
	}
	else if ($password != $password2) {
		$panelMsg = "Passwords do not match";
	}
	else {
		//Check username already exists
		$sqlCheckUsername = "SELECT * FROM users WHERE username = '$username'";
		$usernameExistResult = pg_query($db, $sqlCheckUsername);
		$usernameExistRow = pg_fetch_assoc($usernameExistResult);
		$isExist = pg_num_rows($usernameExistRow);

		if ($isExist > 0) {
			$panelMsg = "Username is taken";
		}
		else {
			//Get UID
			$sqlNextId = "SELECT MAX(uid) + 1 AS maxID FROM users";
			$nextIdResult = pg_query($db, $sqlNextId);
			$row = pg_fetch_assoc($nextIdResult);
			$nextId = $row[maxid];
			
			//Insert new user
			$sqlIn = "INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
					values ('$nextId', '$_POST[usernameInput]', '$_POST[passwordInput]', '$date', false, false, '$_POST[billingAddressInput]')";
			$result = pg_query($db, $sqlIn);
			if ($result) {
				$_SESSION['panelMsg'] = "Created account successfully! Please login.";
				header("Location: login.php");
				exit();
			}
			else{
				$panelMsg = $nextId . pg_last_error();
			}
		}
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
<?php
//Display nagivation bar
if($UNAME == NULL){
	$menu = file_get_contents('menu.html');
	echo $menu;
}
else{
	$menu = file_get_contents('menu-loggedin.html');
	echo $menu;
}

//Display error message pannel
if($panelMsg != ""){
	echo "<div class='w3-panel w3-yellow'><p>" . $panelMsg . "</p></div>";
}
?>
<!-- Register Form -->
<div class="w3-card-4">
  <div class="w3-container w3-brown">
    <h2>Register</h2>
  </div>
  <form class="w3-container" action="register.php" method="POST">
    <p>      
    <label class="w3-text-brown"><b>Username</b></label>
    <input class="w3-input w3-border w3-sand" name="usernameInput" type="text"></p>
    <p>      
    <label class="w3-text-brown"><b>Password</b></label>
    <input class="w3-input w3-border w3-sand" name="passwordInput" type="password"></p>
	<p>      
    <label class="w3-text-brown"><b>Confirm Password</b></label>
    <input class="w3-input w3-border w3-sand" name="passwordSecondInput" type="password"></p>
    <p>
    <label class="w3-text-brown"><b>Billing Address</b></label>
    <input class="w3-input w3-border w3-sand" name="billingAddressInput" type="text"></p>
    <p>
    <input class="w3-btn w3-brown" type="submit" name="submit" value="Register"></button></p>
  </form>
</div>
</body>
</html>