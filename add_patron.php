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
$query;
if(isset($_POST["patronID"])) {
	
	$query = <<<stmt
	SELECT id FROM patrons WHERE id =?;
stmt;
	$my_stmt = $dbConnection->prepare($query);
	$p10 = $_POST["patronID"];
	$p1 = $_POST["patronFirstName"];
	$p2 = $_POST["patronLastName"];
    $p3 = $_POST["birthDate"];
    
	$my_stmt->bind_param('s', $p10);
	$my_stmt->execute();
	$my_stmt->store_result();
	$my_stmt->bind_result($id);

	if($my_stmt->num_rows) {
		$p4 = "";
		if(isset($_POST["joinDate"])) {
			$p4 = $_POST["joinDate"];
		}
        $p5 = "";
		if(isset($_POST["patronStreet"])) {
			$p5 = $_POST["patronStreet"];
		}
        $p6 = "";
		if(isset($_POST["patronCity"])) {
			$p6 = $_POST["patronCity"];
		}
        $p7 = "";
		if(isset($_POST["patronState"])) {
			$p7 = $_POST["patronState"];
		}
        $p8 = "";
		if(isset($_POST["patronZip"])) {
			$p8 = $_POST["patronZip"];
		}
        $p9 = "";
		if(isset($_POST["patronPhone"])) {
			$p9 = $_POST["patronPhone"];
		}
       
		$query = <<<stmt
		UPDATE patrons SET first_name=?, last_name=?, DOB=?,
		joinSince=?, street=?, city=?, state=?, zip=?, phone=?
		WHERE id =?;
stmt;
		$my_stmt = $dbConnection->prepare($query);
		$my_stmt->bind_param('ssssssssss', $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10);
		$my_stmt->execute();
		echo "<p>Patron updated successfully</p>";
	
	} else {
		echo "<p> Could not find Patron in Database</p>";
	}

	$my_stmt->close(); 
	

} else {

	//add Patron
	$query = <<<stmt
	SELECT id FROM patrons p WHERE p.first_name=? AND p.last_name=? AND p.DOB=?;
stmt;
	$my_stmt = $dbConnection->prepare($query);

	$p1 = $_POST["patronFirstName"];
	$p2 = $_POST["patronLastName"];
    $p3 = $_POST["birthDate"];
    
	$my_stmt->bind_param('sss', $p1, $p2, $p3);
	$my_stmt->execute();
	$my_stmt->store_result();
	$my_stmt->bind_result($id);

	if($my_stmt->num_rows) {
		echo "<p> This Patron Already Exists in Database</p>";
		$my_stmt->fetch();
	} else {
		$p4 = "";
		if(isset($_POST["joinDate"])) {
			$p4 = $_POST["joinDate"];
		}
        $p5 = "";
		if(isset($_POST["patronStreet"])) {
			$p5 = $_POST["patronStreet"];
		}
        $p6 = "";
		if(isset($_POST["patronCity"])) {
			$p6 = $_POST["patronCity"];
		}
        $p7 = "";
		if(isset($_POST["patronState"])) {
			$p7 = $_POST["patronState"];
		}
        $p8 = "";
		if(isset($_POST["patronZip"])) {
			$p8 = $_POST["patronZip"];
		}
        $p9 = "";
		if(isset($_POST["patronPhone"])) {
			$p9 = $_POST["patronPhone"];
		}
       
		$query = <<<stmt
		INSERT INTO patrons (first_name, last_name, DOB, joinSince, street, city, state, zip, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);
stmt;
		$my_stmt = $dbConnection->prepare($query);
		$my_stmt->bind_param('sssssssss', $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9);
		$my_stmt->execute();
		echo "<p>Patron added successfully</p>";
	}
	
	$my_stmt->close(); 
}
?>
</div>

<?php
	include 'template_append.php';
?>