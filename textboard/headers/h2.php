<?php

function connect_database()
{		
	$sql_database = 'phplearn';
	$sql_host = 'localhost';
	$sql_user = 'admin';
	$sql_pass = 'root';
	$sql_error = 'Cannot connect to database';

	try
	{
		@mysql_connect($sql_host, $sql_user, $sql_pass);
		@mysql_select_db($sql_database);
	}

	catch (Exception $e)
	{
		exit($sql_error);
	}
}
?>