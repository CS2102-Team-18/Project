<?php
session_start();

$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

if($UNAME != NULL){
	header("Location: profile.php");
	die();
}

include 'db.php';
$db = init_db();		

if (isset($_POST['submit'])) {
	if ($_POST[passwordInput] == $_POST[passwordSecondInput]){
		$sql = "SELECT MAX(uid) + 1 AS maxID FROM users";
		$nextIdResult = pg_query($db, $sql);
		
		$row = pg_fetch_assoc($nextIdResult);
		
		$nextId = $row[maxid];
		
		$sqlIn = "INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin)
				values ('$nextId', '$_POST[usernameInput]', '$_POST[passwordInput]', date '2018-02-03', false)";
		
		$sqlCheckUsername = "SELECT * FROM users WHERE username = '$_POST[usernameInput]'";
		$usernameExistResult = pg_query($db, $sqlCheckUsername);
		
		$usernameExistRow = pg_fetch_assoc($usernameExistResult);
		$isExist = pg_num_rows($usernameExistRow);
		
		$aresult = pg_query($db, $sqlIn);
		if (!$aresult && $isExist != 0) {
			echo "An error occured\n";
			echo "<br>";
		}
		
		else if (!$aresult && $isExist == 0){
			echo "Username already exists!";
		}
		
		else {
			echo "Created account successfully \n ";
		}			
	}
	else {  
	  echo "Password do not match!";
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
    <input class="w3-btn w3-brown" type="submit" name="submit" value="Register"></button></p>
  </form>
</div>
</body>
</html>
