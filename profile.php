<?php
session_start();
$UID = $_SESSION['UID'];		//retrieve UID
$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

if($UNAME == NULL){
	header("Location: login.php");
	die();
}

// Connect to the database. 
include 'db.php';
$db = init_db();	
$result = pg_query($db, "SELECT username FROM users WHERE uid=$UID");
$userRow = pg_fetch_assoc($result);

//logging out
if(isset($_GET['logout'])){
	$link=$_GET['logout'];
	if ($link == 'true'){
		header("Location: logout.php");
		exit();
	}
}

$sqlcheckamountinvested = "SELECT SUM(amount) AS sum FROM investments WHERE investorName =  '$UNAME'";
$investmentresult = pg_query($db, $sqlcheckamountinvested);
$investmentfinal = pg_fetch_all($investmentresult);
$investmentassoc = pg_fetch_assoc($investmentresult);

// $investmentString = sprinf("%d", $investmentassoc[sum]);

// echo '<br> ^^^^^^ </br>'; //space placeholder
// echo '<br> ^^^^^^ </br>'; //space placeholder
// echo "$UNAME";
// echo "$investmentassoc[sum]";

/* for possible step-by-step donate future implementation?
if (isset($_POST['donate'])) {
	header("Location: donate.php");
	exit;
}
*/
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
?>

<!-- Body -->
<div class="w3-container">
	<div class="w3-panel w3-brown">
	  <h1>My Account</h1>
	</div> 
	
	<div class='w3-panel w3-sand w3-leftbar w3-border-brown'>
		<h3>My Profile (<?php echo $UNAME;?>)</h3>

		<a href='changePassword.php' class='w3-button w3-brown'>Change Password</a></br></br>
		<a href='updateBillingAddress.php' class='w3-button w3-brown'>Update Billing Address </a></br></br>
	</div>
	
	<div class='w3-panel w3-sand w3-leftbar w3-border-brown'>
		<h3>My Projects</h3>
		<a href='index.php?search=myprojects' class='w3-button w3-brown'>View My Projects</a>
		<a href='index.php?search=mycompletedprojects' class='w3-button w3-brown w3-margin-left'>View My Completed Projects</a><br><br>
	</div>

	<div class='w3-panel w3-sand w3-leftbar w3-border-brown'>
		<h3>My Investments</h3>
		<a href='index.php?search=myinvestments' class='w3-button w3-brown'>View My Investment Projects</a></br></br>
		<a href='index.php?search=pastinvestments' class='w3-button w3-brown'>View My Past Investments</a></br></br>
		
	</div>
	
	<div class='w3-panel w3-sand w3-leftbar w3-border-brown'>
	<h3> Total Amount Invested</h3>
	<p><?php echo $investmentassoc[sum];?></p>
	</div>
</div>


</body>
</html>
