<?php
// Read input values
//get input data and validate data
//movieID, title, year, type
$title = isset($_POST['title']) ? $_POST['title'] : "";
$year =
  isset($_POST['year']) ? $_POST['year'] : "";
$movieID =
  isset($_POST['movieID']) ? $_POST['movieID'] : "";
  $rating = isset($_POST['rating']) ? $_POST['rating'] : "";
 // var_dump($title);
  //var_dump($year);
  //var_dump($movieID);

$valid = true;
if (empty($movieID)) {
  $valid = false;
} else if (
  empty($title) || empty($year) || empty($rating)
) {
  $valid = false;
}
if (!$valid) {
  echo "Invalid data";
  exit();
}
// Define the SQL statement
$sql = "UPDATE `movies` SET `title` = :title,  `year` = :year, `rating` = :rating WHERE `movieID` = :movieID";

// Define values for the named parameters
$parameterValues = array(
  ":title" => $title,
  ":year" => $year,
  ":movieID" => $movieID,
  ":rating" => $rating
);

// Prepare SQL statement
$stm = $db->prepare($sql);
// execute the statement object
$stm->execute($parameterValues);
// display an appropriate message
echo "Successfully updated the selected movie's information.";
