<?php
/* The request (link) sends two key=value pairs using the GET method: type and movieID */

// By default, a link uses the GET method to send key/value pairs. Use the $_GET array to read the member id
$movieID = (isset($_GET['movieID'])) ? $_GET['movieID'] : null;

// If the $movieID is null then display an error message and exit.
if (!isset($movieID)) {
	echo "You have not selected a movie!";
	exit();
}

// Select member's data
$sql = "select `movieID`, `title`, `year`, `rating` from `movies` where `movieID` = :movieID";
// Define values for named parameters
$parameterValues = array(":movieID" => $movieID);
// Fetch data
$dataList = getAll($sql, $db, $parameterValues);
// Define page title
$pageTitle = "Update Movie Information";

if (isset($pageTitle)) {
	echo "<h4>{$pageTitle}</h4>";
}

// Check if the dataList is not empty
if (count($dataList) === 0) {
	echo "There is no data";
	exit();
}

/* In this case, the SQL should return just one record matching the given movieID.
	  Hence, $dataList is an array that consists of just one matching record
   */
$movie = $dataList[0];
//print_r($member);
// Display the name of the selected member
echo "<p>Title: {$movie['title']}</p>";
// Use an HTML form to display data
?>
<form action="?mode=updateMovieInfo" method="post">
	<table class="table" style="width: 500px;">
		<tbody>
			<tr>
				<td>Title</td>
				<td><input type="text" name="title" reqired value="<?php echo $movie['title']; ?>" />
				</td>
			</tr>
            </td>
			</tr>
			<tr>
				<td>Year</td>
				<td><input type="text" name="year" required value="<?php echo $movie['year']; ?>" /></td>
			</tr>
			<tr>
				<td>Rating</td>
				<td><input type = "text" name = "rating" required value="<?php echo $movie['rating'];?>"/> </td>
</tr>


			</tr>
		</tbody>
	</table>
	<!-- Need to send movieID to the server using an input element (key=value ). 
			We can use a hidden field to define a key=value pair. A hidden field will not be displayed.
		-->
	<input type="hidden" name="movieID" value="<?php echo $movie['movieID']; ?>" />
	<p><button type="submit" class="btn btn-primary">Update Movie Information </button></p>
</form>