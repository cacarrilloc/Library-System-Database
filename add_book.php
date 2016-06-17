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

	//add author
	if(isset($_POST["authorLastName"])) {

		$query = <<<stmt
		SELECT id FROM authors WHERE authors.first_name=? AND authors.last_name=?;
stmt;
		$my_stmt = $dbConnection->prepare($query);

		$p1 = $_POST["authorFirstName"];
		$p2 = $_POST["authorLastName"];
		
		$my_stmt->bind_param('ss', $p1, $p2);
		$my_stmt->execute();
		$my_stmt->store_result();
		$my_stmt->bind_result($id);

		if($my_stmt->num_rows) {
			echo "<p> Author Already Exists in Database</p>";
			$my_stmt->fetch();
			$author_id = $id;
		} else {
			$p3 = "";
			if(isset($_POST["authorCountry"])) {
				$p3 = $_POST["authorCountry"];
			}
			$query = <<<stmt
			INSERT INTO authors (first_name, last_name, country) VALUES (?, ?, ?);
stmt;
			$my_stmt = $dbConnection->prepare($query);
			$my_stmt->bind_param('sss', $p1, $p2, $p3);
			$my_stmt->execute();
			echo "<p>Author added successfully</p>";
			$author_id = $my_stmt->insert_id;
		}

		//add book
		if(isset($_POST["ISBN"])) {
			$query = <<<stmt
		SELECT isbn FROM books WHERE ISBN =?;
stmt;
			$my_stmt = $dbConnection->prepare($query);
			
			$p1 = $_POST["ISBN"];
			
			$my_stmt->bind_param('s', $p1);
			$my_stmt->execute();
			$my_stmt->store_result();
			$my_stmt->bind_result($isbn);
			
			if($my_stmt->num_rows) {
				echo "<p> This book already exists in our database</p>";
			} else {
				$query = <<<stmt
				INSERT INTO books (isbn, title, publisher, publish_date, country, category, pages) VALUES (?, ?, ?, ?, ?, ?, ?);
stmt;
				$p2 = $_POST["bookTitle"];
				$p3 = $_POST["bookPublisher"];
				$p4 = $_POST["publishDate"];
				$p5 = $_POST["publishCountry"];
				$p6 = $_POST["bookCategory"];
				$p7 = $_POST["bookPages"];
				$my_stmt = $dbConnection->prepare($query);
				$my_stmt->bind_param('sssssss', $p1, $p2, $p3, $p4, $p5, $p6, $p7);
				$my_stmt->execute();
				echo "<p> Book added successfully</p>";
                
				//now add to book_authors table
				$query = <<<stmt
				INSERT INTO book_authors (author_id, isbn) VALUES (?, ?);
stmt;
				$my_stmt = $dbConnection->prepare($query);
				$my_stmt->bind_param('ss', $author_id, $p1);
				$my_stmt->execute();
				echo "<p> Book-Author relationship added successfully</p>";
			}
		}
		$my_stmt->close(); 
	} else if (isset($_POST["issue"])) {
		$query = <<<stmt
		SELECT issue FROM magazines WHERE issue=?;
stmt;
		$my_stmt = $dbConnection->prepare($query);
		$p1 = $_POST["issue"];		
		$my_stmt->bind_param('s', $p1);
		$my_stmt->execute();
		$my_stmt->store_result();
		$my_stmt->bind_result($issue);
		
		if($my_stmt->num_rows) {
			echo "<p> This magazine issue already exists in our database</p>";
		} else {
			$query = <<<stmt
			INSERT INTO magazines (issue, title, issue_date, country, category, pages) VALUES (?, ?, ?, ?, ?, ?);
stmt;
			$p2 = $_POST["magazineTitle"];
			$p3 = $_POST["issueDate"];
			$p4 = $_POST["magazineCountry"];
			$p5 = $_POST["magazineCategory"];
			$p6 = $_POST["magazinePages"];
			$my_stmt = $dbConnection->prepare($query);
			$my_stmt->bind_param('ssssss', $p1, $p2, $p3, $p4, $p5, $p6);
			$my_stmt->execute();
			echo "<p> Magazine added successfully</p>";	
		}
		$my_stmt->close(); 
	} else if(isset($_POST["deleteBook"])) {
		$query = <<<stmt
		SELECT isbn FROM books WHERE isbn=?;
stmt;
		$my_stmt = $dbConnection->prepare($query);
		$p1 = $_POST["deleteBook"];		
		$my_stmt->bind_param('s', $p1);
		$my_stmt->execute();
		$my_stmt->store_result();
		$my_stmt->bind_result($isbn);
		
		if($my_stmt->num_rows) {

			$query = <<<stmt
			DELETE FROM books WHERE books.isbn =?;
stmt;
			$my_stmt = $dbConnection->prepare($query);
			$my_stmt->bind_param('s', $p1);
			$my_stmt->execute();
			$result = $my_stmt->affected_rows;
			if($result == -1) {
				echo "<p>Query error</p>";
			}
			else if($result == 0) {
				echo "<p> No rows affected </p>";
			} else {
				echo "<p> Book deleted successfully. Rows affected: " . $result . "</p>";
			}
		} else {
			echo "<p> Book not found</p>";
		}
		$my_stmt->close(); 
	} else if(isset($_POST["deleteMagazine"])) {
		$query = <<<stmt
		SELECT issue FROM magazines WHERE issue=?;
stmt;
		$my_stmt = $dbConnection->prepare($query);
		$p1 = $_POST["deleteMagazine"];		
		$my_stmt->bind_param('s', $p1);
		$my_stmt->execute();
		$my_stmt->store_result();
		$my_stmt->bind_result($issue);
		
		if($my_stmt->num_rows) {
			$query = <<<stmt
			DELETE FROM magazines WHERE issue =?;
stmt;
			$my_stmt = $dbConnection->prepare($query);
			$my_stmt->bind_param('s', $p1);
			$my_stmt->execute();
			$result = $my_stmt->affected_rows;
			if($result == -1) {
				echo "<p>Query error</p>";
			}
			else if($result == 0) {
				echo "<p> No rows affected </p>";
			} else {
				echo "<p> Magazine deleted successfully. Rows affected: " . $result . "</p>";
			}
		} else {
			echo "<p> Magainze not found</p>";
		}
		$my_stmt->close(); 
	} else if(isset($_POST["deleteAuthorL"])) {
		$query = <<<stmt
		SELECT id FROM authors WHERE first_name=? AND last_name=?;
stmt;
		$my_stmt = $dbConnection->prepare($query);
		$p1 = $_POST["deleteAuthorF"];		
		$p2 = $_POST["deleteAuthorL"];		
		$my_stmt->bind_param('ss', $p1, $p2);
		$my_stmt->execute();
		$my_stmt->store_result();
		$my_stmt->bind_result($id);
		
		if($my_stmt->num_rows) {
			$result = 0;
			while($my_stmt->fetch()) {
				$p1 = $id;
				$query = <<<stmt
				DELETE FROM authors WHERE id =?;
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
					$result++;
				}
			}
			echo "<p> Author(s) deleted successfully. Rows affected: " . $result . "</p>";
		} else {
			echo "<p> Book not found</p>";
		}
		$my_stmt->close(); 
	}
?>
</div>

<?php
	include 'template_append.php';
?>