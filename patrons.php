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
			<h1 class="page-header"><strong>Patrons</strong></h1>
			<h4>Our patrons page should be used to add and view patrons who are allowed to borrow books or magazines from the library. Each entry in this list will contain personal information about the patrons. Please feel free to add Patrons! You are also
			able to update a Patron's information. Make sure to fill in each field when updating their information or it will be left as blank.</h4>
		</div>
	</div>

    <div class="row addNew">
		<a class="btn btn-default center" href="#addPatron" role="button" data-toggle="collapse">+ Add Patron </a>
		<div id="addPatron" class="collapse">
			<form method="POST" action="add_patron.php">

			  <fieldset class="form-group">
				<label for="patronFirstName"> First Name: </label>
				<input type="text" class="form-control" name="patronFirstName" id="patronFirstName">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronLastName"> Last Name: </label>
				<input type="text" class="form-control" name="patronLastName" id="patronLastName">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="birthDate"> Date of Birth: </label>
				<input type="date" class="form-control" name="birthDate" id="birthDate">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="joinDate">Joined Since: </label>
				<input type="date" class="form-control" name="joinDate" id="joinDate">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronStreet">Street Address: </label>
				<input type="text" class="form-control" name="patronStreet" id="patronStreet">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronCity">City: </label>
				<input type="text" class="form-control" name="patronCity" id="patronCity">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronState">State: </label>
				<input type="text" class="form-control" name="patronState" id="patronState">
			  </fieldset>

              <fieldset class="form-group">
				<label for="patronZip">Zip Code: </label>
				<input type="number" class="form-control" name="patronZip" id="patronZip">
			  </fieldset>

              <fieldset class="form-group">
				<label for="patronPhone">Phone Number: </label>
				<input type="tel" class="form-control" name="patronPhone" id="patronPhone">
			  </fieldset>

			  <input type="submit" class="btn btn-default" value="Add Patron" id="addPatronButton"></input>
			 </form>
		</div>
    </div>
	</br>
	
	<div class="row addNew">
		<a class="btn btn-default center" href="#updatePatron" role="button" data-toggle="collapse">! Update Patron Info </a>
		<div id="updatePatron" class="collapse">
			<form method="POST" action="add_patron.php">

			<fieldset class="form-group">
				<label for="patronID">Patron ID to Update: </label>
				<input type="number" class="form-control" name="patronID" id="patronID">
			  </fieldset>
			  <fieldset class="form-group">
				<label for="patronFirstName"> First Name: </label>
				<input type="text" class="form-control" name="patronFirstName" id="patronFirstName">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronLastName"> Last Name: </label>
				<input type="text" class="form-control" name="patronLastName" id="patronLastName">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="birthDate"> Date of Birth: </label>
				<input type="date" class="form-control" name="birthDate" id="birthDate">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="joinDate">Joined Since: </label>
				<input type="date" class="form-control" name="joinDate" id="joinDate">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronStreet">Street Address: </label>
				<input type="text" class="form-control" name="patronStreet" id="patronStreet">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronCity">City: </label>
				<input type="text" class="form-control" name="patronCity" id="patronCity">
			  </fieldset>

			  <fieldset class="form-group">
				<label for="patronState">State: </label>
				<input type="text" class="form-control" name="patronState" id="patronState">
			  </fieldset>

              <fieldset class="form-group">
				<label for="patronZip">Zip Code: </label>
				<input type="number" class="form-control" name="patronZip" id="patronZip">
			  </fieldset>

              <fieldset class="form-group">
				<label for="patronPhone">Phone Number: </label>
				<input type="tel" class="form-control" name="patronPhone" id="patronPhone">
			  </fieldset>

			  <input type="submit" class="btn btn-default" value="Update Patron Info" id="addPatronButton"></input>
			 </form>
		</div>
    </div>
	</br>
	</br>
	
	
	
	<div id="search">
			<form method="POST" action="patrons.php">
			  <fieldset class="form-group">
				<label for="searchInput">Search by Patron Last Name to Find Patron Info </label>
				<input type="text" class="form-control" name="searchInput" id="searchInput">
			  </fieldset>
			 <input type="submit" class="btn btn-default" value="Search Inventory"></input>
			 </form>
		</div>
		<div class="row" id="tableTemplate">
		
<?php 
	if(isset($_POST["searchInput"])) {
		
	$query = <<<stmt
	SELECT id, first_name, last_name, joinSince, street, city, state, zip, phone FROM patrons WHERE last_name =?;
stmt;
		$p1 = $_POST["searchInput"];
		if (($my_stmt = $dbConnection->prepare($query))) {
					$my_stmt->bind_param('s', $p1);
					$my_stmt->execute();
					//$ab_stmt->bind_result($result);
					
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
                    <th>Member Since</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Phone</th>
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
	</br></br>
	

        <div class="row">
         <h2 class="sub-header">List of All Patrons</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Member Since</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Phone</th>
                </tr>
            </thead>

        <tbody>
			<?php
			try {
				$allPatronsQuery = <<<stmt
				SELECT first_name, last_name, DOB, joinSince, street, city, state, zip, phone FROM patrons;
stmt;
				if (($ab_stmt = $dbConnection->prepare($allPatronsQuery))) {
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