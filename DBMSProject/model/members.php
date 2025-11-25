<?php
// 1. define SQL statement
$sql = "SELECT `username` FROM `user` order by `userid`";

// 2. Define values for named parameters. There are no parameters in this SQL statement. Use the default.
// 3. Fetch result set
$resultSet = getAll($sql, $db);

// 4. Display result
$pageTitle = "List of Members";
$columns = array("Username"); // we will use a two-column table to display members
displayResultSet($pageTitle, $resultSet, $columns);
