<?php
/* The request (link) sends two key=value pairs using the GET method: type and UserId */

// By default, a link uses the GET method to send key/value pairs. Use the $_GET array to read the User id
$UserId = (isset($_GET['UserId'])) ? $_GET['UserId'] : null;

// If the $UserID is null then display an error message and exit.
if (!isset($UserId)) {
	echo "You have not selected a User!";
	exit();
}

// Select User's data
$sql = "select `UserID`, `username` from `User` where `UserID` = :UserId";
// Define values for named parameters
$parameterValues = array(":UserId" => $UserId);
// Fetch data
$dataList = getAll($sql, $db, $parameterValues);
// Define page title
$pageTitle = "Update User Information";

if (isset($pageTitle)) {
	echo "<h4>{$pageTitle}</h4>";
}

// Check if the dataList is not empty
if (count($dataList) === 0) {
	echo "There is no data";
	exit();
}

/* In this case, the SQL should return just one record matching the given UserId.
	  Hence, $dataList is an array that consists of just one matching record
   */
$User = $dataList[0];
//print_r($User);
// Display the name of the selected User
echo "<p>Name: {$User['username']}</p>";
// Use an HTML form to display data
?>
<form action="?mode=updateUserInfo" method="post">
	<table class="table" style="width: 500px;">
		<tbody>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" required value="<?php echo $User['username']; ?>" /></td>
			</tr>
		</tbody>
	</table>
	<!-- Need to send UserId to the server using an input element (key=value ). 
			We can use a hidden field to define a key=value pair. A hidden field will not be displayed.
		-->
	<input type="hidden" name="UserId" value="<?php echo $User['UserID']; ?>" />
	<p><button type="submit" class="btn btn-primary">Update User Information </button></p>
</form>