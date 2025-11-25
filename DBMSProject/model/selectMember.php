<?php
// Need to display a list of Users so that we can select a User to update data
$sql = "select * from `User` order by `userID`";

// This SQL statement does not use any parameters. Use the default $parameterValues array.
$dataList = getAll($sql, $db);

// Define page title
$pageTitle = "Select a User form the List to Update Information";
// Include a template to display a list of Users
if (isset($pageTitle)) {
  echo "<h4>{$pageTitle}</h4>";
}

// Check if the dataList is not empty
if (count($dataList) === 0) {
  echo "There are no Users";
  exit();
}

foreach ($dataList as $row) {
  /* Each element is an associative array with three elements: UserId, firstName, and lastName.
*/
  echo "<ul>";
  echo "<li><a href='?mode=displayUserInfo&UserId={$row['UserID']}'>{$row['username']}</a></li>";
  echo "</ul>";
}
