
<?php
	session_start();
	$UID = $_SESSION['UID'];		//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$PID = $_SESSION['PID'];
	$PNAME = $_SESSION['PNAME'];

	if($UNAME == NULL){
		header("Location: login.php");
		die();
	}
	
  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	//Display selected project based on $PID and $PNAME
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$PNAME' AND projectid = '$PID'");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}
	/* debugging
	echo "<br><br><br>HELLO"; //testing
	echo "<br>";
	echo "$PID";
	echo "<br>";
	echo "$PNAME";
	echo "<br>debugging----ignore above this line";

	echo "<br>";
	*/
	$arr = pg_fetch_all($result);

	foreach ($arr as $value){
		$arr2 = array_values($value);
		$projname = $arr2[0];
		$projdesc = $arr2[1];
		$projSDate = $arr2[2];
		$projEDate = $arr2[3];
		$projOName = $arr2[5];
		$projamount = $arr2[6];
		$projprogress = $arr2[7];
		$projcat = $arr2[8];
	}

	//execute payment query
	if(isset($_POST['pay'])){
		//query here and show confirmation/bring to payment confirm page
		
		//get invest amount, invest type, current date
		$payvalue = $_POST['payvalue'];
		$payfield = ucfirst($_POST['payfield']);
		$dateinvested = date("Y-m-d");

		//update investments in db
		$sql = "insert into investments(amount, dateinvested, investmentid, investorname, investmenttype, projectid, ownername)
				select '$payvalue', '$dateinvested', CAST((MAX(CAST(investmentID AS INT)) + 1) AS VARCHAR(100)), '$UNAME', '$payfield', '$PID', '$PNAME'
				from investments";
		$result = pg_query($db, $sql);
		
		if (!$result) {
			echo "error updating investments from db";
		}

		$sql = "DO LANGUAGE plpgsql
				$$
				DECLARE x INTEGER := $payvalue;
				BEGIN
					BEGIN
						update projectsownership set progress = progress + x where projectid = '$PID' and ownername = '$PNAME';
						if (x<0) THEN RAISE EXCEPTION USING
							ERRCODE ='PVLTZ',
							MESSAGE ='pay value less than zero',
							hint='update with higher value';
						end if;
						exception when SQLSTATE 'PVLTZ' then raise notice 'error';
					END;

					BEGIN
						update projectsownership
						set projectstatus = CASE
											WHEN progress >= targetamount then 'COMPLETED'
											ELSE projectstatus
											END
						where projectid = '$PID' and ownername = '$PNAME';
						if((select progress from projectsownership where projectid='1' and ownername='Alice') >= (select targetamount from projectsownership where projectid='1' and ownername='Alice')) THEN
							RAISE NOTICE 'Hello';
						END IF;
					END;
				raise notice 'Payment value: %', x;
				END;
				$$";

		$result = pg_query($db, $sql);
		if (!$result) {
			echo "error updating projectsOwnership from db";
		}

		//header("Location: index.php");
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
<div class="w3-card-4">
	<div class="w3-container w3-brown">
		<h2>Fund this Project!</h2>
	</div>
<?php //need to update database with payment types
echo "
	<form class='w3-container' method='POST'>
	<p>
	<label class='w3-text-brown'><b>Contribution Amount:</b></label>
	<input class='w3-input w3-border w3-sand' name='payvalue' type='number'></p>
	<p>
	<label class='w3-text-brown'><b>Make Contribution With:</b></label>
    <select name='payfield'>
		<option value='paypal'>Paypal</option>
		<option value='enets'>eNETS</option>
		<option value='creditcard'>Credit Card</option>
    </select>
    <input class='w3-btn w3-brown' type='submit' name='pay' value='Contribute!'></button></p>

	<div class='w3-bottombar w3-border-brown'></div>
	
    <p>      
    <label class='w3-text-brown'><b>Project Name</b></label></p>
    <label class='w3-text-black'>$projname</label></p>

    <p>      
    <label class='w3-text-brown'><b>Project Description</b></label></p>
    <label class='w3-text-black'>$projdesc</label></p>

	<p>      
    <label class='w3-text-brown'><b>Start Date</b></label></p>
    <label class='w3-text-black'>$projSDate</label></p>

	<p>      
    <label class='w3-text-brown'><b>End Date</b></label></p>
    <label class='w3-text-black'>$projEDate</label></p>

	<p>      
    <label class='w3-text-brown'><b>Owner Name</b></label></p>
    <label class='w3-text-black'>$projOName</label></p>

	<p>      
    <label class='w3-text-brown'><b>Target Amount</b></label></p>
    <label class='w3-text-black'>$projamount</label></p>

	<p>      
    <label class='w3-text-brown'><b>Progress</b></label></p>
    <label class='w3-text-black'>$projprogress</label></p>

	<p>      
    <label class='w3-text-brown'><b>Category</b></label></p>
    <label class='w3-text-black'>$projcat</label></p>
	</form>";
?>
</div>

<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
