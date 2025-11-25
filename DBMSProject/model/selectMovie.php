<?php
// Need to display a list of members so that we can select a member to update data
$sql = "select * from `movies` order by `movieID`";

// This SQL statement does not use any parameters. Use the default $parameterValues array.
$dataList = getAll($sql, $db);

// Define page title
$pageTitle = "Select a Movie from the List to Update Information";
// Include a template to display a list of members
if (isset($pageTitle)) {
  echo "<h4>{$pageTitle}</h4>";
}

// Check if the dataList is not empty
if (count($dataList) === 0) {
  echo "There are no movies";
  exit();
}

foreach ($dataList as $row) {
  /* Each element is an associative array with three elements: memberId, firstName, and lastName.
*/
  echo "<ul>";
  echo "<li><a href='?mode=displayMovieInfo&movieID={$row['movieID']}'>{$row['title']}</a></li>";
  echo "</ul>";
}
