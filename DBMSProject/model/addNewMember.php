<?php
$username = $_POST['username']?? "";


/* if the first name, last name, or username is empty then display
an error message.
*/
if ($username === '') {
  echo "Invalid data";
  exit;
} 
  // Define the SQL statement
$sql = "INSERT INTO `User`(username)
VALUES (:username)";
  // Define values for the named parameters

  /* Important: password must be encrypted. We can use the buil-in md5( ) method to encrypt the password */
  $parameters = [
    ":username" => $username
  ];

  // Prepare SQL statement
  $stm = $db->prepare($sql);
  // execute the statement object
  $stm->execute($parameters);
  // display an appropriate message
  echo "<p>Added a new User</p>";