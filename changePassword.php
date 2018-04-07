<?php
	session_start();
	$UID = $_SESSION['UID'];	//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$panelMsg = "";

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	
		
//logging out
if(isset($_GET['logout'])){
	$link=$_GET['logout'];
	if ($link == 'true'){
		header("Location: logout.php");
		exit;
	}
}

if (isset($_POST['submit'])) {

$sqlCheckValidPassword = "SELECT pssword FROM users WHERE uid = $UID AND username = '$UNAME'";
$validPasswordResult = pg_query($db, $sqlCheckValidPassword);
$validPassword = pg_fetch_result ($validPasswordResult, 0, 0);

// Debugging. Kept for reference. Ignore.
	
//$validPasswordType = gettype($validPassword);
//$textType = gettype($_POST[oldPassword]);
//echo 'hello';
//echo '<br> test </br>';
//echo '<br> test </br>';
//echo "<br>$validPasswordResult</br>";
//echo "<br>$validPassword</br>";
//echo "$_POST[oldPassword]";
//echo "$validPasswordType";
//echo "$textType";

$passwordLength = strlen("$_POST[passwordInput]");
//echo '<br> test </br>';
//echo "$passwordLength";


	if ("$_POST[oldPassword]" != "$validPassword") {
		$panelMsg = "Wrong password credentials";
	}	

	else if ($_POST[passwordInput] == $_POST[passwordSecondInput]){		
		$sql = "update users set pssword = '$_POST[passwordInput]' where uid = $UID and username = '$UNAME'";

		$result = pg_query($db, $sql);
		$error = pg_last_error($db);
		if(strpos($error, 'ERROR') !== false){
			$pos = strpos($error, 'CONTEXT');
			echo substr_replace($error, "", $pos, strlen($error));
			//echo "$error";
		} else {
			$panelMsg = "Password changed successfully!";
		}

	}
	else {  
	  	$panelMsg = "Password do not match!";
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
	if($_SESSION['ADMIN'] == "true"){
		$menu = file_get_contents('menu-admin.html');
	} else {
		$menu = file_get_contents('menu-loggedin.html');
	}
	echo $menu;
}
//Display error message pannel
if($panelMsg != ""){
	echo "<div class='w3-panel w3-yellow'><p>" . $panelMsg . "</p></div>";
}
?>


<!-- Change Password Form -->
<div class="w3-card-4">
  <div class="w3-container w3-brown">
    <h2>Change Password</h2>
  </div>
  <form class="w3-container" action="changePassword.php" method="POST">
    <p> 
	<label class="w3-text-brown"><b>Old Password</b></label>
    <input class="w3-input w3-border w3-sand" name="oldPassword" type="password"></p>    
	<p>
	<label class="w3-text-brown"><b>Password</b></label>
    <input class="w3-input w3-border w3-sand" name="passwordInput" type="password"></p>
    <p>      
    <label class="w3-text-brown"><b>Confirm Password</b></label>
    <input class="w3-input w3-border w3-sand" name="passwordSecondInput" type="password"></p>
    <p>
    <input class="w3-btn w3-brown" type="submit" name="submit" value="Change Password"></button></p>
  </form>
</div>
</body>
</html>
