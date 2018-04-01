<?php
	session_start();
	$UID = $_SESSION['UID'];	//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$CUID= $_SESSION['CUID']; //retrive changeable UID
 	// $CUNAME = $_SESSION['CUNAME']; //retrieve changeable USERNAME
	
	
	if($UNAME == NULL){
		header("Location: login.php");
		die();
	}
  	// Connect to the database. 
        include 'db.php';
	$db = init_db();	

	if (isset($_POST['submit'])) {	

		if ($_POST[editUserName] <> NULL) {
		$sqlEditUserName = "UPDATE users SET username = '$_POST[editUserName]' WHERE uid = '$CUID'";
		$editUserNameResult = pg_query($db, $sqlEditUserName);
		echo "$editUserNameResult";
		}

		if ($_POST[editPassword] <> NULL) {
		$sqlEditPassword = "UPDATE  users SET pssword = '$_POST[editPassword]' WHERE  uid = '$CUID'";
		$editPasswordResult = pg_query($db, $sqlEditPassword);
		echo "$editPasswordResult";
		}
		
		if ($_POST[editBillingAddress] <> NULL) {
		$sqlEditAddress = "UPDATE users SET billingaddress = '$_POST[editBillingAddress]' WHERE  uid = '$CUID'";
		$editAddressResult = pg_query($db, $sqlEditAddress);
		echo "$editAddressResult";
		}

	}
	
	if (isset($_POST['submitAdmin'])) {	

		$sqlEditAdmin = "UPDATE users SET isadmin = TRUE WHERE  uid = '$CUID'";
		$editAdminResult = pg_query($db, $sqlEditAdmin);
		echo "$editAdminResult";
	

	}
	
	if (isset($_POST['submitBan'])) {	

		$sqlEditBan = "UPDATE users SET isbanned = TRUE WHERE  uid = '$CUID'";
		$editBanResult = pg_query($db, $sqlEditBan);
		echo "$editBanResult";

	}
	
		if (isset($_POST['removeBan'])) {	

		$sqlRemoveBan = "UPDATE users SET isbanned = FALSE WHERE  uid = '$CUID'";
		$editBanResult = pg_query($db, $sqlRemoveBan);
		echo "$editBanResult";

	}
	
		if (isset($_POST['removeAdmin'])) {	

		$sqlRemoveAdmin = "UPDATE users SET isadmin = FALSE WHERE  uid = '$CUID'";
		$editAdminResult = pg_query($db, $sqlRemoveAdmin);
		echo "$editAdminResult";
	

	}
	
	//Display selected project based on $PID and $PNAME
	$result = pg_query($db, "SELECT * FROM users WHERE  uid = '$CUID'");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}
	


	// echo "<br><br><br>HELLO"; //testing
	// echo "<br>";
	// echo "$PID";
	// echo "<br>";
	// echo "$PNAME";
	// echo "<br>debugging----ignore above this line";
		// echo "^^^^^";
	// echo "^^^^^'";
	// echo "$CUID";
	// echo "$CUNAME";
	// echo "$editUserNameResult";
	// echo "$editAddressResult";
	// echo "$editPasswordResult";

	// echo "<br>";

	$details = pg_fetch_all($result);

	foreach ($details as $details){
		$row = array_values($details);
		$uid = $row[0];
		$username = $row[1];
		$pssword = $row[2];
		$isadmin = $row[4];
		$isbanned = $row[5];
		$billingAddress = $row[6];
	}
		echo "<br><br><br>HELLO"; //testing
	echo "<br>";
	echo "$PID";
	echo "<br>";
	echo "$PNAME";
	echo "<br>debugging----ignore above this line";
		echo "^^^^^";
	echo "^^^^^'";
	echo "$CUID";
	echo "$CUNAME";
	echo "$editUserNameResult";
	echo "$editAddressResult";
	echo "$editPasswordResult";

	echo "<br>";
	echo "$isadmin";
	echo "$isbanned";

?> 

<!DOCTYPE html>  
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
	if($_SESSION['ADMIN'] == "true"){
		$menu = file_get_contents('menu-admin.html');
	} else {
		$menu = file_get_contents('menu-loggedin.html');
	}
	echo $menu;
}
?>

<!-- Slide Show
<div class="w3-content w3-section" style="max-height:500px">
  <img class="mySlides" src="img/water.jpg" style="width:100%">
  <img class="mySlides" src="img/castle.jpg" style="width:100%">
  <img class="mySlides" src="img/road.jpg" style="width:100%">
</div>
-->

<!-- Main Body -->
<?php
if($isadmin == 't' && $isbanned == 'f'){
	echo "
	<form class='w3-container' method='POST'>
    <p><label class='w3-text-brown'><b>Username</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editUserName' value='" . $username. "' type='text'></p>

    <p><label class='w3-text-brown'><b>Password</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editPassword' value='" . $pssword . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Billing Address</b></label></p>     
	<p><input class='w3-input w3-border w3-sand' name='editBillingAddress' value='" . $billingaddress . "' type='text'></p>
	
	 <input class='w3-btn w3-brown' type='submit' name='removeAdmin' value='Remove Admin'></button></p>
	 <input class='w3-btn w3-brown' type='submit' name='submitBan' value='Ban User'></button></p>
	   
	 <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit User Information'></button></p>
	</form>";
 }
 
 if($isadmin == 'f' && $isbanned == 't' ){
	echo "
	<form class='w3-container' method='POST'>
    <p><label class='w3-text-brown'><b>Username</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editUserName' value='" . $username. "' type='text'></p>

    <p><label class='w3-text-brown'><b>Password</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editPassword' value='" . $pssword . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Billing Address</b></label></p>     
	<p><input class='w3-input w3-border w3-sand' name='editBillingAddress' value='" . $billingaddress . "' type='text'></p>
	
	 <input class='w3-btn w3-brown' type='submit' name='submitAdmin' value='Make Admin'></button></p>
	 <input class='w3-btn w3-brown' type='submit' name='removeBan' value='Remove Ban'></button></p>
	   
	 <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit User Information'></button></p>
	</form>";
 }
 
 if($isadmin == 't' && $isbanned == 't'){
	echo "
	<form class='w3-container' method='POST'>
    <p><label class='w3-text-brown'><b>Username</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editUserName' value='" . $username. "' type='text'></p>

    <p><label class='w3-text-brown'><b>Password</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editPassword' value='" . $pssword . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Billing Address</b></label></p>     
	<p><input class='w3-input w3-border w3-sand' name='editBillingAddress' value='" . $billingaddress . "' type='text'></p>
	
	 <input class='w3-btn w3-brown' type='submit' name='removeAdmin' value='Remove Admin'></button></p>
	 <input class='w3-btn w3-brown' type='submit' name='removeBan' value='Remove Ban'></button></p>
	   
	 <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit User Information'></button></p>
	</form>";
 }
 
  if($isadmin == 'f' && $isbanned == 'f' ){
	echo "
	<form class='w3-container' method='POST'>
    <p><label class='w3-text-brown'><b>Username</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editUserName' value='" . $username. "' type='text'></p>

    <p><label class='w3-text-brown'><b>Password</b></label></p>
	<p><input class='w3-input w3-border w3-sand' name='editPassword' value='" . $pssword . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Billing Address</b></label></p>     
	<p><input class='w3-input w3-border w3-sand' name='editBillingAddress' value='" . $billingaddress . "' type='text'></p>
	
	 <input class='w3-btn w3-brown' type='submit' name='submitAdmin' value='Make Admin'></button></p>
	 <input class='w3-btn w3-brown' type='submit' name='submitBan' value='Ban User'></button></p>
	   
	 <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit User Information'></button></p>
	</form>";
 }
?>

<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
