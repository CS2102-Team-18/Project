 <?php
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	// Safeguard
	$sql = "SELECT isAdmin FROM users WHERE username = '$UNAME' AND uid = '$UID'";
	$result = pg_query($db, $sql);
	$admincheck = pg_fetch_result($result,0 ,0);
	if($admincheck != 't') {
		$_SESSION['ADMIN'] = NULL;
		header("Location: index.php");
		exit;
	}

	$SEARCH = $_GET['search'];
	$SEARCHVALUE = $_POST['searchvalue'];
	$SEARCHFIELD = $_POST['searchfield'];
	
	$myinvestmentsflag = 0;
	$pastinvestmentsflag = 0;
	$totalamountflag = 0;

	//Query for all users
	$sql = "select UID, userName, dateJoined, isAdmin, isBanned, billingAddress from users ORDER BY UID ASC";
	$result = pg_query($db, $sql);
	
	//$result = pg_query($db, "SELECT * FROM projectsOwnership");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}


	$users = pg_fetch_all($result);
	$x = 0;
	$table_contents = NULL;
	foreach ($users as $user){
		$row = array_values($user);
		$userid = $row[0];
		$username = $row[1];
		$datejoined = $row[2];
		$isadmin = $row[3];
		$isbanned = $row[4];
		$billingaddress = $row[5];
		
		//Generate HTML code for each project
		$table_contents .= "<div class='w3-panel w3-pale-green w3-leftbar w3-border-green'>";
		$table_contents .= "<h3><b>" . $userid . " . " . $username . "</b></h3>";
		$table_contents .= "<p>Date Joined: " . $datejoined . "</p>";
		$table_contents .= "<p>Admin: " . $isadmin . "</p>";
		$table_contents .= "<p>Banned: " . $isbanned . "</p>";
		$table_contents .= "<p>Billing Address: " . $billingaddress . "</p>";
		$table_contents .= "<a href='?detail=" . $userid . $username . "' class='w3-button w3-green'>Edit User Details</a>";
		$table_contents .= "<br><br></div>";
	}

	if(isset($_GET['detail'])){
		$link=$_GET['detail'];
		if(!empty($link)){
			//set session variables for project id and project name..acts as a global variable?
			$userid = preg_replace('/\D/', '', $link); //retrieve userID
			$username = preg_replace('/[0-9]+/', '', $link); //retrieve userName
			$_SESSION['CUID']=$userid;
			$_SESSION['CUNAME']=$username;
			header("Location: edituser.php");
		}
	}
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
<div class="w3-row">
  <div class="w3-col m3 w3-center"><p></p></div>
  <div class="w3-col m6 w3-center"><p></p>
  	<form class="w3-container w3-center" action="users.php" method="POST">
		<p>
		<input class="w3-input w3-border w3-sand" name="searchvalue" type="text"></p>
		<label class="w3-text-brown"><b>Search Under:</b></label>
		<select name="searchfield">
			<option value="projectname">UserID</option>
			<option value="projectdescription">User name</option>
		</select>
		<input class="w3-btn w3-brown" type="submit" name="search" value="Search"></button>
	</form>
  </div>
  <div class="w3-col m3 w3-center"><p></p></div>
</div>

<div class="w3-container">
	<?php
	echo $table_contents;
	?>
</div>
  
<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
