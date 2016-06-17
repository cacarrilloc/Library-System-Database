/***************************************************************
** Authors: Carlos Carrillo                                    *
** Date:   06/05/2016                                          *
** Description: Database system for a library.                 *
***************************************************************/

<?php
	include 'template_prepend.php';
	
?>

<div class="row">
	<div class="giveMePadding col-sm-6 col-sm-offset-1">
		</br><h2>Communicating with Database...</h2>
	</div>
</div>

<div>

<?php

function addInv($conn, $p1, $p2, $p3, $p4) {
	$query = <<<stmt
		INSERT INTO inventory (isbn, issue, acquisition_date, unit_price) VALUES (?, ?, ?, ?);
stmt;
		$my_stmt = $conn->prepare($query);
		$my_stmt->bind_param('ssss', $p1, $p2, $p3, $p4);
		$my_stmt->execute();
		$result = $my_stmt->affected_rows;
		if($result == -1) {
			echo "<p>Query error</p>";
		}
		else if($result == 0) {
			echo "<p> No rows affected </p>";
		} else {
			echo "<p> Inventory item added successfully. Rows affected: " . $result . "</p>";
		}
}


	//add inventory
	if(isset($_POST["acquisitionDate"])) {
		$p1 = NULL;
		$p2 = NULL;
		$p3 = $_POST["acquisitionDate"];
		$p4 = $_POST["price"];
		if(isset($_POST["ISBN"])) {
			$p1 = $_POST["ISBN"];
			$query = <<<stmt
			SELECT isbn FROM books WHERE isbn =?;
stmt;
			$my_stmt = $dbConnection->prepare($query);

			$my_stmt->bind_param('s', $p1);
			$my_stmt->execute();
			$my_stmt->store_result();
			$my_stmt->bind_result($isbn);
			
			if($my_stmt->num_rows) {
				//add book to inventory
				addInv($dbConnection, $p1,$p2,$p3,$p4);
			} else {
				echo "<p> Book not found in resources database </p>";
			}
		} else if(isset($_POST["issue"])) {
			$p2 = $_POST["issue"];
			$query = <<<stmt
			SELECT issue FROM magazines WHERE issue=?;
stmt;
			$my_stmt = $dbConnection->prepare($query);
			
			$my_stmt->bind_param('s', $p2);
			$my_stmt->execute();
			$my_stmt->store_result();
			$my_stmt->bind_result($issue);
			
			if($my_stmt->num_rows) {
				//add magazine to inventory
				addInv($dbConnection, $p1,$p2,$p3,$p4);
			} else {
				echo "<p> Magazine not found in resources database </p>";
			}
		}
	} else if(isset($_POST["deleteBook"])) {
			$query = <<<stmt
		SELECT pid FROM inventory WHERE pid=?;
stmt;
		$my_stmt = $dbConnection->prepare($query);
		$p1 = $_POST["deleteBook"];			
		$my_stmt->bind_param('s', $p1);
		$my_stmt->execute();
		$my_stmt->store_result();
		$my_stmt->bind_result($pid);
		
		if($my_stmt->num_rows) {
			$my_stmt->fetch();
			$p1 = $pid;

			$query = <<<stmt
			DELETE FROM inventory WHERE pid =?;
stmt;
			$my_stmt = $dbConnection->prepare($query);
			$my_stmt->bind_param('s', $p1);
			$my_stmt->execute();
			$worked = $my_stmt->affected_rows;
			if($worked == -1) {
				echo "<p>Query error</p>";
			}
			else if($worked == 0) {
				echo "<p> No rows affected </p>";
			} else {
				echo "<p> Inventory item deleted successfully. Rows affected: " . $worked . "</p>";
			}
		} else {
			echo "<p> Item not found in inventory</p>";
		}
	}
	
?>


</div>


<?php
	include 'template_append.php';
?>