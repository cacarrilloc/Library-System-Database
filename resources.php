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
			<h1 class="page-header"><strong>Resources</strong></h1>
			<h4>Our resource page should be used to manage books, magazines, and authors which, after being added,
			are then available for our library to purchase and add to its inventory. If you know any books, magazines, or
			authors that aren't listed,	please feel free to add them! </h4>
		</div>
	</div>

	<div class="row addNew">
		<a class="btn btn-default center" href="#addBook" role="button" data-toggle="collapse">+ Add Book</a>
		<div id="addBook" class="collapse">
			<form method="POST" action="add_book.php">
			  <fieldset class="form-group">
				<label for="ISBN">ISBN: </label>
				<input type="number" class="form-control" name="ISBN" id="ISBN">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="bookTitle">Title: </label>
				<input type="text" class="form-control" name="bookTitle" id="bookTitle">
			  </fieldset>
			  <fieldset class="form-group">
				<small class="text-muted">If the author is not in our database, it will be added</small></br>
				<label for="authorFirstName">Author First Name: </label>
				<input type="text" class="form-control" name="authorFirstName" id="authorFirstName">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="authorLastName">Author Last Name: </label>
				<input type="text" class="form-control" name="authorLastName" id="authorLastName">
			  </fieldset>
			   <fieldset class="form-group">
				<label for="authorCountry">Author Country: </label>
				<input type="text" class="form-control" name="authorCountry" id="authorCountry">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="bookPublisher">Publisher: </label>
				<input type="text" class="form-control" name="bookPublisher" id="bookPublisher">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="publishDate">Publish Date: </label>
				<input type="date" class="form-control" name="publishDate" id="publishDate">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="publishCountry">Publish Country: </label>
				<input type="text" class="form-control" name="publishCountry" id="publishCountry">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="bookCategory">Category: </label>
				<input type="text" class="form-control" name="bookCategory" id="bookCategory">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="bookPages">Number of Pages: </label>
				<input type="number" class="form-control" name="bookPages" id="bookPages">
			  </fieldset>
			  <input type="submit" class="btn btn-default" value="Add Book" id="addBookButton"></input>
			 </form>	
			
		</div>
		
		</br>
		</br>
		
		<a class="btn btn-default center" href="#addMagazine" role="button" data-toggle="collapse">+ Add Magazine</a>
		<div id="addMagazine" class="collapse">
		<form method="POST" action="add_book.php">
			  <fieldset class="form-group">
				<label for="magazineTitle">Title: </label>
				<input type="text" class="form-control" name="magazineTitle" id="magazineTitle">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="issue">Issue: </label>
				<input type="number" class="form-control" name="issue" id="issue">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="issueDate">Issue Date: </label>
				<input type="date" class="form-control" name="issueDate" id="issueDate">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="magazineCountry">Country: </label>
				<input type="text" class="form-control" name="magazineCountry" id="magazineCountry">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="magazinePages">Number of Pages: </label>
				<input type="number" class="form-control" name="magazinePages" id="magazinePages">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="magazineCategory">Category: </label>
				<input type="text" class="form-control" name="magazineCategory" id="magazineCategory">
			  </fieldset>
			   <input type="submit" class="btn btn-default" value="Add Magazine" id="addMagazineButton"></input>
			 </form>	
		</div>
		</br>
		</br>
		<a class="btn btn-default center" href="#addAuthor" role="button" data-toggle="collapse">+ Add Author</a>
		<div id="addAuthor" class="collapse">
			<form method="POST" action="add_book.php">
			  <fieldset class="form-group">
				<label for="authorFirstName">First Name: </label>
				<input type="text" class="form-control" name="authorFirstName" id="authorFirstName">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="authorLastName">Last Name: </label>
				<input type="text" class="form-control" name="authorLastName" id="authorLastName">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="authorCountry">Country of Origin: </label>
				<input type="text" class="form-control" name="authorCountry" id="authorCountry">
			  </fieldset>
			  <input type="submit" class="btn btn-default" id="addAuthorButton" value="Add Author"></input>
			 </form>	
		</div>
	</br>
		</br>
	<a class="btn btn-default center" href="#deleteResource" role="button" data-toggle="collapse">- Delete Resource</a>
		<div id="deleteResource" class="collapse">
			<form method="POST" action="add_book.php">
			  <fieldset class="form-group">
				<label for="deleteBook">Book ISBN:  </label>
				<input type="number" class="form-control" name="deleteBook" id="deleteBook">
			  </fieldset>
			  <input type="submit" class="btn btn-default" value="Delete Book" id="deleteBookButton"></input>
			 </form>
			 <form method="POST" action="add_book.php">
			  <fieldset class="form-group">
				<label for="deleteMagazine">Magazine Issue:  </label>
				<input type="number" class="form-control" name="deleteMagazine" id="deleteMagazine">
			  </fieldset>
			  <input type="submit" class="btn btn-default" value="Delete Magazine" id="deleteMagazineButton"></input>
			 </form>
			 <form method="POST" action="add_book.php">
			  <fieldset class="form-group">
				<label for="deleteAuthorF">Author First Name:  </label>
				<input type="text" class="form-control" name="deleteAuthorF" id="deleteAuthorF">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="deleteAuthorL">Author Last Name:  </label>
				<input type="text" class="form-control" name="deleteAuthorL" id="deleteAuthorL">
			  </fieldset>
			  <input type="submit" class="btn btn-default" value="Delete Author" id="deleteAuthorButton"></input>
			 </form>			 
			
		</div>
	</div>
	<div class="row">
	  <h2 class="sub-header">List of All Books</h2>
	  <div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>ISBN</th>
			  <th>Title</th>
			  <th>Author First</th>
			  <th>Author Last</th>
			  <th>Date Published</th>
			  <th>Pages</th>
			</tr>
		  </thead>
		  <tbody>
			
			<?php 
			try {
				$allBooksQuery = <<<stmt
				SELECT b.isbn, b.title, a.first_name, a.last_name, b.publish_date, b.pages FROM authors a 
				INNER JOIN book_authors ba ON ba.author_id = a.id 
				INNER JOIN books b ON b.isbn = ba.isbn;
stmt;
				if (($ab_stmt = $dbConnection->prepare($allBooksQuery))) {
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

	<div class="row">
	  <h2 class="sub-header">List of All Magazines</h2>
	  <div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>Title</th>
			  <th>Issue</th>
			  <th>Date Published</th>
			  <th>Pages</th>
			</tr>
		  </thead>
		  <tbody>
			

			<?php
			try {
				$allMagazinesQuery = <<<stmt
				SELECT title, issue, issue_date, pages FROM magazines;
stmt;
				if (($ab_stmt = $dbConnection->prepare($allMagazinesQuery))) {
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

	<div class="row">
	  <h2 class="sub-header">List of All Authors</h2>
	  <div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>First Name</th>
			  <th>Last Name</th>
			  <th>Country</th>
			</tr>
		  </thead>
		  <tbody>
			
			<?php
			try {
				$allAuthorsQuery = <<<stmt
				SELECT first_name, last_name, country FROM authors;
stmt;
				if (($ab_stmt = $dbConnection->prepare($allAuthorsQuery))) {
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