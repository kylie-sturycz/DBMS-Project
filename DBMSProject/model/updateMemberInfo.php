<?php
// Read input values
//get input data and validate data
$username =
  isset($_POST['username']) ? $_POST['username'] : "";
$UserId =
  isset($_POST['UserId']) ? $_POST['UserId'] : "";

$valid = true;
if (empty($UserId)) {
  $valid = false;
} else if (
  empty($username)
) {
  $valid = false;
}
if (!$valid) {
  echo "Invalid data";
  exit();
}
// Define the SQL statement
$sql = "UPDATE `User`
SET `username` = :username
WHERE `UserID` = :UserId";

// Define values for the named parameters
$parameterValues = array(
  ":username" => $username
  //https://www.php.net/manual/en/function.md5.php
  //Calculate the md5 hash of a string
  //Note: It is not recommended to use this function to secure
  //passwords, due to the fast nature of this hashing algorithm.
  //Instead, password_hash() function is a common approach
  //See more details: https://www.php.net/manual/en/function.password-hash.php
  //password_hash() creates a new password hash using a strong one-way hashing algorithm.
);

// Prepare SQL statement
$stm = $db->prepare($sql);
// execute the statement object
$stm->execute($parameterValues);
// display an appropriate message
echo "Successfully updated selected User's information.";
