 <?php
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$SEARCHVALUE = $_SESSION['SEARCHVALUE']; //retrieve search value
	$SEARCHFIELD = $_SESSION['SEARCHFIELD']; //retrieve search field

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	//Display searched projects
	/* debugging
	echo "<br><br>";
	echo "<h2>$SEARCHVALUE $SEARCHFIELD</h2>";
	*/
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE LOWER($SEARCHFIELD) LIKE LOWER('%$SEARCHVALUE%')");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}

	$arr = pg_fetch_all($result);
	$x = 0;
	$table_contents = NULL;
	foreach ($arr as $value){
		$row = array_values($value);
		$pid = $row[4];	//record pid of the project
		$pname = $row[5]; //record owner of project
		$table_contents .= "<tr>";
		foreach($value as $value2){
			if($x == 0){
				$table_contents .= "<td><a href='?detail=$pid$pname'>" . $value2 . "</a></td>";
			} else if($x == 4) {
				//do nothing
			} else {
				$table_contents .= "<td>" . $value2 . "</td>";
			}
			$x++;
			if($x == 9){
				$table_contents .= "</tr>";
				$x = 0;
			}
		}
	}

	if(isset($_GET['detail'])){
		$link=$_GET['detail'];
		if(!empty($link)){
			//set session variables for project id and project name..acts as a global variable?
			$pid = preg_replace('/\D/', '', $link); //retrieve pid
			$pname = preg_replace('/[0-9]+/', '', $link); //retrieve pname
			$_SESSION['PID']=$pid;
			$_SESSION['PNAME']=$pname;
			if($pname == $UNAME){
				$_SESSION['OWNPROJECT']=true;
			} else {
				$_SESSION['OWNPROJECT']=NULL;
			}
			header("Location: detailedproj.php");
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
        <th>Project Name</th>
        <th>Project Description</th>
        <th>Start Date</th>
		<th>End Date</th>
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
