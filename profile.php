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

//view all Projects
if (isset($_POST['allProjects'])) {
	header("Location: index.php");
	exit;
}

//view own Projects
if (isset($_POST['myProjects'])) {
	header("Location: ownproj.php");
	exit;
}

/* for donate future implementation
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
	<form class="w3-container" method="POST">
    <p>
    <input class="w3-btn w3-brown" type="submit" name="allProjects" value="View All Projects"></button>
	<p>
	<input class="w3-btn w3-brown" type="submit" name="myProjects" value="View My Projects"></button>
	<p>
	<input class="w3-btn w3-brown" type="submit" name="donate" value="Contribute to a Project"></button>
	</p>
  </form>
</div>


</body>
</html>
