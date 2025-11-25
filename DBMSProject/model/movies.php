<?php
if (isset($_GET['genre']) && $_GET['genre'] !== "all") {
  $genre = $_GET['genre'];
  $sql = "SELECT `title`, `type`, `year` FROM `movies` where `type` = :genre order by `title`";
  // 2. Define values for named parameters.
  $parameterValues = array(":genre" => $genre);

  // Define page title
  $pageTitle = "List of {$genre} movies";
} else {
  // Default output is a list of all the movies
  $sql = "SELECT `title`, `type`, `year` FROM `movies` order by `title`";
  // 2. Define values for named parameters. There are no parameters in this SQL statement. Use the default.
  $parameterValues = null;
  // Define page title
  $pageTitle = "List of movies";
}

// 3. Fetch result set
$resultSet = getAll($sql, $db, $parameterValues);

// 4. Display result
$columns = array("Title", "Genre", "Year"); // three columns, same as the field names in the SQL statement
displayResultSet($pageTitle, $resultSet, $columns);
