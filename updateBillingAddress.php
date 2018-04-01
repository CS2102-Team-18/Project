<?php
	session_start();
	$UID = $_SESSION['UID'];	//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$panelMsg = "";
	
  	// Connect to the database. 
	include 'db.php';
	$db = init_db();	
		

if (isset($_POST['submit'])) {
	$sqlIn = "UPDATE users SET billingaddress = '$_POST[billingAddressInput]' WHERE uid = $UID AND username = '$UNAME'";
	$result = pg_query($db, $sqlIn);
	if ($result) {
		$panelMsg = "Billing Address Successfully Changed";
	}
	else {
		$panelMsg = "An unexpected error occured";
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
<!-- Register Form -->
<div class="w3-card-4">
  <div class="w3-container w3-brown">
    <h2>Change Billing Address</h2>
  </div>
  <form class="w3-container" action="updateBillingAddress.php" method="POST">
    <p>      
    <label class="w3-text-brown"><b>Billing Address</b></label>
    <input class="w3-input w3-border w3-sand" name="billingAddressInput" type="text"></p>
    <p>
    <input class="w3-btn w3-brown" type="submit" name="submit" value="Update Billing Address"></button></p>
<p></p>
  </form>
<p></p>
</div>
</body>
</html>
