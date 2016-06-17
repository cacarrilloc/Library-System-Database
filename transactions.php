/***************************************************************
** Author: Carlos Carrillo                                     *
** Date:   06/05/2016                                          *
** Description: Database system for a library.                 *
***************************************************************/

<?php
	include 'template_prepend.php';
	
?>
	
<div class="giveMePadding">
	<div class="row">
		<div>
			<h1 class="page-header"><strong>Transactions</strong></h1>
			<h4>Our transactions page should be used to track Inventory movement and Patrons' fine payments.  The book or magazine being checked out
			must exist in the Library's Inventory and the Patron must have been created in the system as well. You can use the search functions to
			find an Inventory ID by Book/Magazine title or search for a Patron's ID using their last name. Lastly, you can also filter out an individual patron's transaction history</h4>
		</div>
	</div>

<div class="row addNew">
		<a class="btn btn-default center" href="#addTransaction" role="button" data-toggle="collapse">+ Add Transaction</a>
		<div id="addTransaction" class="collapse">
			<form method="POST" action="transactions.php">
			  <fieldset class="form-group">
				<label for="iid">Inventory ID: </label>
				<input type="number" class="form-control" name="iid" id="iid">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="pid">Patron ID: </label>
				<input type="number" class="form-control" name="pid" id="pid">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="tDate">Transaction Date: </label>
				<input type="date" class="form-control" name="tDate" id="tDate">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="type">Transaction Type :</label>
				<select class="form-control" name="type" id="type">
					<option value="Checked Out">Check Out</option>
					<option value="Checked In">Check In</option>
					<option value="Pay Fine">Pay Fine</option>
				</select>
			  </fieldset>
			  <fieldset class="form-group">
				<label for="amount">Transaction Amount (leave blank if n/a) :</label>
				<input type="number" step="any" class="form-control" name="amount" id="amount">
			  </fieldset>
			  <input type="submit" class="btn btn-default" value="Add Transaction" id="addTransaction"></input>
			 </form>		
		</div>
		
		
		<div>
	<?php	
		if(isset($_POST["iid"])) {

		$query = <<<stmt
		SELECT pid FROM inventory WHERE pid=?;
stmt;
		$my_stmt = $dbConnection->prepare($query);

		$p1 = $_POST["iid"];
		
		$my_stmt->bind_param('s', $p1);
		$my_stmt->execute();
		$my_stmt->store_result();
		$my_stmt->bind_result($id);

		if(!$my_stmt->num_rows) {
			echo "<p> Could not find Inventory ID</p>";
		} else {
			if(isset($_POST["pid"])) {
				$query = <<<stmt
				SELECT id FROM patrons WHERE id=?;
stmt;
				$my_stmt = $dbConnection->prepare($query);

				$p2 = $_POST["pid"];
				
				$my_stmt->bind_param('s', $p2);
				$my_stmt->execute();
				$my_stmt->store_result();
				$my_stmt->bind_result($id);
				
				if(!$my_stmt->num_rows) {
					echo "<p> Could not find Patron ID</p>";
				} else {
					$query = <<<stmt
			INSERT INTO transactions (product_id, patron_id, date, type, amount) VALUES (?, ?, ?, ?, ?);
stmt;
			$p3 = $_POST["tDate"];
			$p4 = $_POST["type"];
			$p5 = $_POST["amount"];
			
			$my_stmt = $dbConnection->prepare($query);
			$my_stmt->bind_param('sssss', $p1, $p2, $p3, $p4, $p5);
			$my_stmt->execute();
			echo "<p>Transaction " . $my_stmt->insert_id . " added successfully</p>";
					}
		}
	}
}
?>
		</div>
		</br>
		</br>

		<div id="searchInventory">
			<form method="POST" action="transactions.php">
			  <fieldset class="form-group">
				<label for="searchInputInv">Search by Magazine or Book name to find Inventory ID </label>
				<input type="text" class="form-control" name="searchInputInv" id="searchInputInv">
			  </fieldset>
			 <input type="submit" class="btn btn-default" value="Search Inventory"></input>
			 </form>
		</div>
		<div class="row" id="tableTemplate">
		
<?php 
	if(isset($_POST["searchInputInv"])) {
		
	$query = <<<stmt
	SELECT inventory.pid, books.title AS btitle, magazines.title AS mtitle
	FROM inventory
	LEFT JOIN books ON inventory.isbn = books.isbn
	LEFT JOIN magazines ON magazines.issue = inventory.issue WHERE 
		books.title =? OR magazines.title =?;
stmt;
		$p1 = $_POST["searchInputInv"];
		$p2 = $_POST["searchInputInv"];
		if (($my_stmt = $dbConnection->prepare($query))) {
					$my_stmt->bind_param('ss', $p1, $p2);
					$my_stmt->execute();
					
					$result = $my_stmt->get_result();
					$i = 0;
					$colHeaders = array();
					$colData = array();
					while($row = mysqli_fetch_assoc($result)) {
						if($i == 0) {
							foreach($row as $colHeader => $val) {
								$colHeaders[] = $colHeader;
							}
						}
						$colData[] = $row;
						$i++;
					}
					
					echo '<h2 class="sub-header">Search Results:</h2>
	  <div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>Inventory ID</th>
			  <th>Book Title (if book)</th>
			  <th>Magazine Title (if magazine)</th>
			</tr>
		  </thead>
		  <tbody>';
					
					foreach($colData as $r) {
							echo "<tr>";
							foreach($colHeaders as $colHeader) {
								echo "<td>" . $r[$colHeader] . "</td>";
							}
							echo "</tr>";
					}
					
				echo '</tbody></table></div>';
			
				$my_stmt->close();
		}
	}
?>
		</div>

		</br>
		</br>
		<div id="search">
			<form method="POST" action="transactions.php">
			  <fieldset class="form-group">
				<label for="searchInput">Search by Patron Last Name to Find Patron ID </label>
				<input type="text" class="form-control" name="searchInput" id="searchInput">
			  </fieldset>
			 <input type="submit" class="btn btn-default" value="Search Inventory"></input>
			 </form>
		</div>
		<div class="row" id="tableTemplate">
		
<?php 
	if(isset($_POST["searchInput"])) {
		
	$query = <<<stmt
	SELECT id, first_name, last_name FROM patrons WHERE last_name =?;
stmt;
		$p1 = $_POST["searchInput"];
		if (($my_stmt = $dbConnection->prepare($query))) {
					$my_stmt->bind_param('s', $p1);
					$my_stmt->execute();
					
					$result = $my_stmt->get_result();
					$i = 0;
					$colHeaders = array();
					$colData = array();
					while($row = mysqli_fetch_assoc($result)) {
						if($i == 0) {
							foreach($row as $colHeader => $val) {
								$colHeaders[] = $colHeader;
							}
						}
						$colData[] = $row;
						$i++;
					}
					
					echo '<h2 class="sub-header">Search Results:</h2>
	  <div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>Patron ID</th>
			  <th>First Name</th>
			  <th>Last Name</th>
			</tr>
		  </thead>
		  <tbody>';
								
					
					foreach($colData as $r) {
							echo "<tr>";
							foreach($colHeaders as $colHeader) {
								echo "<td>" . $r[$colHeader] . "</td>";
							}
							echo "</tr>";
					}
					
				echo '</tbody></table></div>';
			
				$my_stmt->close();
		}
	}
?>
		
		
</div>

</br>
		</br>
		<div id="filter">
			<form method="POST" action="transactions.php">
			  <fieldset class="form-group">
				<label for="filter"> Filter Transactions by Patron ID</label>
				<input type="number" class="form-control" name="filter" id="filter">
			  </fieldset>
			 <input type="submit" class="btn btn-default" value="Filter"></input>
			 </form>
			 <?php
			 if(isset($_POST["filter"])) {
				 echo '</br></br><form action="transactions.php">';
				 echo '<input type="submit" class="btn btn-default" value="Remove Filter"></input></form>';
			 }
			 ?>
		</div>


</div>
	
<div class="row">
	<?php
	if(isset($_POST["filter"])) {
		echo '<h2 class="sub-header">List of All Transactions for Patron ID ' . $_POST["filter"] .'</h2>';
	} else {
		echo '<h2 class="sub-header">List of All Transactions</h2>';
		}
	 ?>
	  <div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>Transaction ID</th>
			  <th>Transaction Date</th>
			  <th>Transaction Type</th>
			  <th>Patron First Name</th>
			  <th>Patron Last Name</th>
			  <th>Book Name (if book)</th>
			  <th>Magazine Name</th>
			  <th>Author First Name (if book) </th>
			  <th>Author Last Name (if book) </th>
			</tr>
		  </thead>
		  <tbody>
			

			<?php
			try {
				$allInventory;
				if(isset($_POST["filter"])) {
					$allInventory = <<<stmt
					SELECT id, date, type, first_name, last_name, btitle, title, author_fname, author_lname FROM (SELECT t.id, t.date, t.type, p.first_name, p.last_name, t.product_id, i.isbn, i.issue AS missue FROM transactions t INNER JOIN
					patrons p ON t.patron_id = p.id INNER JOIN 
					inventory i ON i.pid = t.product_id WHERE p.id =?) AS d LEFT JOIN 
					magazines m ON m.issue = d.missue LEFT JOIN (SELECT b.isbn AS bisbn, b.title AS btitle, a.first_name AS author_fname, a.last_name AS author_lname FROM books b INNER JOIN
					book_authors ba ON ba.isbn = b.isbn INNER JOIN
					authors a ON a.id = ba.author_id) as e ON e.bisbn = d.isbn GROUP BY id ORDER BY id
stmt;
				
				} else { 
					$allInventory = <<<stmt
					SELECT id, date, type, first_name, last_name, btitle, title, author_fname, author_lname FROM (SELECT t.id, t.date, t.type, p.first_name, p.last_name, t.product_id, i.isbn, i.issue AS missue FROM transactions t INNER JOIN
					patrons p ON t.patron_id = p.id INNER JOIN 
					inventory i ON i.pid = t.product_id) AS d LEFT JOIN 
					magazines m ON m.issue = d.missue LEFT JOIN (SELECT b.isbn AS bisbn, b.title AS btitle, a.first_name AS author_fname, a.last_name AS author_lname FROM books b INNER JOIN
					book_authors ba ON ba.isbn = b.isbn INNER JOIN
					authors a ON a.id = ba.author_id) as e ON e.bisbn = d.isbn GROUP BY id ORDER BY id
stmt;
				}
				if (($ab_stmt = $dbConnection->prepare($allInventory))) {
					
					if(isset($_POST["filter"])) {
						$p1 = $_POST["filter"];
						$ab_stmt->bind_param('s', $p1);
					}
					$ab_stmt->execute();
					
					$result = $ab_stmt->get_result();
					$i = 0;
					$colHeaders = array();
					$colData = array();
					while($row = mysqli_fetch_assoc($result)) {
						if($i == 0) {
							foreach($row as $colHeader => $val) {
								$colHeaders[] = $colHeader;
							}
						}
						$colData[] = $row;
						$i++;
					}
								
					
					foreach($colData as $r) {
							echo "<tr>";
							foreach($colHeaders as $colHeader) {
								echo "<td>" . $r[$colHeader] . "</td>";
							}
							echo "</tr>";
					}
			
			
				$ab_stmt->close();
				} else {
					echo "Statement Prep Failed" . $dbConnection->connect_errno . " " . $dbConnection->connect_error;
				}
			} catch(Exception $e) {
				echo 'caught exception: ' . $e->getMessage();
			}
			?>
		   
		  </tbody>
		</table>
	  </div>
	</div>

	</div>
<?php
	include 'template_append.php';
?>