<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Enter your desired username and password</h2>
  <ul>
    <form name="display" action="createaccount.php" method="POST" >
      <li>Username:</li>
      <li><input type="text" name="usernameInput" /></li>
	  <li>Password:</li>	  
	  <li><input type="text" name="passwordInput" /></li>
	  <li>Double Confirm Password:</li>	  
	  <li><input type="text" name="passwordSecondInput" /></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
  
		$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=167294381");			
  
  if (isset($_POST['submit'])) {
		if ($_POST[passwordInput] == $_POST[passwordSecondInput]){
		$sql = "SELECT MAX(uid) + 1 AS maxID FROM users";
		$nextIdResult = pg_query($db, $sql);
		
		$row = pg_fetch_assoc($nextIdResult);
		
		$nextId = $row[maxid];
		
		$sqlIn = "INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin)
				values ('$nextId', '$_POST[usernameInput]', '$_POST[passwordInput]', date '2018-02-03', false)";
		
		$sqlCheckUsername = "SELECT * FROM users WHERE username = '$_POST[usernameInput]'";
		$usernameExistResult = pg_query($db, $sqlCheckUsername);
		
		$usernameExistRow = pg_fetch_assoc($usernameExistResult);
		$isExist = pg_num_rows($usernameExistRow);
		
		$aresult = pg_query($db, $sqlIn);
		if (!$aresult && $isExist != 0) {
			echo "An error occured\n";
			echo "<br>";
		}
		
		else if (!$aresult && $isExist == 0){
			echo "Username already exists!";
		}
		
		else {
			echo "Created account successfully \n ";
		}
					
  }
  
    else {
	  
	  echo "Password do not match!";
  }
  }
		
    ?>  
</body>
</html>
