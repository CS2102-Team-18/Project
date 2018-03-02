<?php

function init_db(){
	$dbname = "postgres";
	$user = "postgres";
	$password = "password";
	return pg_connect("host=localhost port=5432 dbname=" . $dbname . " user=" . $user . " password=" . $password);	
}
?>