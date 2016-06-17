/***************************************************************
** Authors: Carlos Carrillo                                    *
** Date:   06/05/2016                                          *
** Description: Database system for a library.                 *
***************************************************************/

<?php
	Turn on error reporting
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	
	//should be added to config file with gitignore attribute
	$dbHost = 'oniddb.cws.oregonstate.edu';
	$dbName = 'carrilca-db';
	$dbUserName = 'carrilca-db';
	$dbPassword = 'FyCZ946fgVFJu6ju';
	
	$dbConnection = new mysqli($dbHost, $dbUserName, $dbPassword, $dbName);
	if($dbConnection->connect_errno){
		echo "Connection error " . $dbConnection->connect_errno . " " . $dbConnection->connect_error;
	} else {
		echo "Connection to Database established!";
	}
	
?>