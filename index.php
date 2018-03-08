 <?php
	
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	//Display all projects
	//echo "<h2>ALL PROJECTS</h2>";
	$result = pg_query($db, "SELECT * FROM projectsOwnership");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}

	$arr = pg_fetch_all($result);
	$x = 0;
	$table_contents = NULL;
	foreach ($arr as $value){
		$table_contents .= "<tr>";
		foreach($value as $value2){
			$table_contents .= "<td>" . $value2 . "</td>";
			$x++;
			if($x == 9){
				$table_contents .= "</tr>";
				$x = 0;
			}
		}
	}
	
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
	$menu = file_get_contents('menu-loggedin.html');
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
<div class="w3-container">
  <table class="w3-table-all">
    <thead>
      <tr class="w3-red">
        <th>First Name</th>
        <th>Last Name</th>
        <th>Start Date</th>
		<th>End Date</th>
		<th>ID</th>
		<th>Owner</th>
		<th>Target</th>
		<th>Progress</th>
		<th>Category</th>
      </tr>
    </thead>
	<?php
	echo $table_contents;
	?>
  </table>
</div>
  
<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
