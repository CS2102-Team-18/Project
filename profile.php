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
		exit;
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

<!-- Body -->
<div class="w3-container">
	<?php
	//Display user ID
	echo "<h2>Welcome $UNAME !</h2>";
	?>
</div>


</body>
</html>
