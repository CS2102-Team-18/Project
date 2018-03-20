<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Search for Crowdfunding projects</h2>
  <ul>
    <form name="display" action="crowdfunding.php" method="POST" >
      <li>Username:</li>
      <li><input type="text" name="usernameInput" /></li>
	  <li>Password:</li>	  
	  <li><input type="text" name="passwordInput" /></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
  
  session_start();
  
  $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=167294381");	
  $UID = $_SESSION['UID'];
  ?>  
</body>
</html>
