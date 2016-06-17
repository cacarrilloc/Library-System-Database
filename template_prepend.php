/***************************************************************
** Authors: Carlos Carrillo                                    *
** Date:   06/05/2016                                          *
** Description: Database system for a library.                 *
***************************************************************/

<!DOCTYPE html>

<?php
	include 'db_connect.php';
?>

<!--http://getbootstrap.com/examples/dashboard/ -->
<html lang='en'>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Library Database Project</title>
		
		<!-- Latest compiled and minified CSS for Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
		integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<!-- Custom css file -->
		<link rel="stylesheet" href="public/css/style.css">
	</head>
	
	
	<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="true" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Library Database Project</a>
        </div>
      
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul id="analBeads" class="nav nav-sidebar">
             <li><a href="index.php">Home</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="patrons.php">Patrons</a></li>
            <li><a href="transactions.php">Transactions</a></li>
			<li><a href="resources.php">Resources</a></li>
          </ul>
        </div>
        
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
