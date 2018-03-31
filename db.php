<?php

function init_db(){
	$dbname = "Project1";
	$user = "postgres";
	$password = "wzcs2102";
	return pg_connect("host=localhost port=5432 dbname=" . $dbname . " user=" . $user . " password=" . $password);	
}
?>