<?php
	session_start();
	$UID = $_SESSION['UID'];	//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

  	// Connect to the database. 
       include 'db.php';
	$db = init_db();	
		

if (isset($_POST['submit'])) {
	if ($_POST[passwordInput] == $_POST[passwordSecondInput]){		
		$sqlIn = "UPDATE users SET pssword = '$_POST[passwordInput]' WHERE uid = $UID AND username = '$UNAME'";
		$result = pg_query($db, $sqlIn);
		echo 'Password Changed Successfully!';
	}
}

	else {  
	  echo 'Password do not match!';
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
  <form class="w3-container" action="updateBillingAddress.php" method="POST">
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
<p></p>
  </form>
<p></p>
</div>
</body>
</html>
