/***************************************************************
** Authors: Carlos Carrillo                                    *
** Date:   06/05/2016                                          *
** Description: Database system for a library.                 *
***************************************************************/

<?php
	include 'template_prepend.php';
	
?>

<div class="giveMePadding">
	<div class="row">
		<div>
			<h1 class="page-header"><strong>Inventory</strong></h1>
			<h4>Our inventory page should be used to manage the library's current inventory. Books and Magazines
			can be added (newly purchased) or removed (lost/destroyed) from this page. In order for an item to be added
			to the library's inventory, it must exist in the resources page.
			</h4>
		</div>
	</div>
	
	<div class="row addNew">
		<a class="btn btn-default center" href="#addBook" role="button" data-toggle="collapse">+ Add Book to Inventory</a>
		<div id="addBook" class="collapse">
			<form method="POST" action="inventory_mgmt.php">
			  <fieldset class="form-group">
				<label for="ISBN">ISBN: </label>
				<input type="number" class="form-control" name="ISBN" id="ISBN">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="acquisitionDate">Acquisition Date: </label>
				<input type="date" class="form-control" name="acquisitionDate" id="acquisitionDate">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="price">Purchase Price ($):</label>
				<input type="number" step="any" class="form-control" name="price" id="price">
			  </fieldset>
			  <input type="submit" class="btn btn-default" value="Add Book" id="addBookButton"></input>
			 </form>		
		</div>
		
		</br>
		</br>
		
		<a class="btn btn-default center" href="#addMagazine" role="button" data-toggle="collapse">+ Add Magazine to Inventory</a>
		<div id="addMagazine" class="collapse">
		<form method="POST" action="inventory_mgmt.php">
			  <fieldset class="form-group">
				<label for="issue">Issue: </label>
				<input type="number" class="form-control" name="issue" id="issue">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="acquisitionDate">Acquisition Date: </label>
				<input type="date" class="form-control" name="acquisitionDate" id="acquisitionDate">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="price">Purchase Price ($):</label>
				<input type="number" step="any" class="form-control" name="price" id="price">
			  </fieldset>
			   <input type="submit" class="btn btn-default" value="Add Magazine" id="addMagazineButton"></input>
			</form>	
		</div>
		</br>
		</br>
		<a class="btn btn-default center" href="#delete" role="button" data-toggle="collapse">- Remove Inventory</a>
		<div id="delete" class="collapse">
			<form method="POST" action="inventory_mgmt.php">
			  <fieldset class="form-group">
				<label for="deleteBook">Inventory ID to Remove: </label>
				<input type="number" class="form-control" name="deleteBook" id="deleteBook">
			  </fieldset>
			  <input type="submit" class="btn btn-default" value="Remove Inventory" id="deleteAuthorButton"></input>
			 </form>			 
			
		</div>
		</br>
		</br>
		<div id="search">
			<form method="POST" action="inventory.php">
			  <fieldset class="form-group">
				<label for="searchInput">Search by Magazine or Book NAME to find Inventory ID </label>
				<input type="text" class="form-control" name="searchInput" id="searchInput" placeholder="e.g. 'The Raven' OR 'Forbes'">
			  </fieldset>
			 <input type="submit" class="btn btn-default" value="Search Inventory"></input>
			 </form>
		</div>
	</div>
		<div class="row" id="tableTemplate">
		
<?php 
	if(isset($_POST["searchInput"])) {
		
	$query = <<<stmt
	SELECT inventory.pid, books.title AS btitle, magazines.title AS mtitle
	FROM inventory
	LEFT JOIN books ON inventory.isbn = books.isbn
	LEFT JOIN magazines ON magazines.issue = inventory.issue WHERE 
		books.title =? OR magazines.title =?;
stmt;
		$p1 = $_POST["searchInput"];
		$p2 = $_POST["searchInput"];
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
			  <th>PID</th>
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
	

<div class="row">
	  <h2 class="sub-header">List of All Inventory Items</h2>
	  <div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>ID</th>
			  <th>ISBN (if book)</th>
			  <th>Issue (if magazine)</th>
			  <th>Acquisition Date</th>
			  <th>Purchase Price</th>
			</tr>
		  </thead>
		  <tbody>
			

			<?php
			try {
				$allInventory = <<<stmt
				SELECT pid, isbn, issue, acquisition_date, unit_price FROM inventory;
stmt;
				if (($ab_stmt = $dbConnection->prepare($allInventory))) {
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


<?php
	include 'template_append.php';
?>


