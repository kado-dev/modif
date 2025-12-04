<?php
	//Connect To Database
	$hostname='202.70.136.34';
	$username='root';
	$password='user_demo';
	$dbname='db_elogistik_pusat_dummy';
	// $usertable='test';
	// $yourfield = 'lat';

	$connect = mysql_connect($hostname,$username,$password);// OR DIE ('Unable to connect to database! Please try again later.');
	$select_db = mysql_select_db($dbname);

	if(($connect)&&($select_db))
	{
		echo "connection successfully";
	}else{
		echo "connection failed";
	}
?>