 <?php
    // Establish database connection
    include_once("model/pdoconnect.php");
    /* Check if the database connection is established. If not, exit the program. */
    if (!$db) {
        echo "Could not connect to the database";
        exit();
    }

    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="style.css">
 </head>

 <body>
     <div class='container-fluid'>
         <!-- include page content -->
         <div class="row">
             <div class="col-sm-12">
                 <img src="http://www.southjersey.com//images/page_movies.jpg" alt="Movie store" height="100px">
             </div>
             <nav class="navbar navbar-expand-lg menu-bar">
                 <ul class="navbar-nav mr-auto">
                     <li class="nav-item menu-link active">
                         <a class="nav-link" href="index.php">Home</a>
                     </li>
                     <li class="nav-item menu-link">
                         <a class="nav-link" href="index.php?mode=members">Members</a>
                     </li>
                     <li class="nav-item menu-link">
                         <a class="nav-link" href="index.php?mode=movies">Movies</a>
                     </li>
                     </li>
                     <li class="nav-item menu-link">
                         <a class="nav-link" href="index.php?mode=displayNewMemberForm">Add New Member</a>
                     </li>
                     <li class="nav-item menu-link">
                         <a class="nav-link" href="index.php?mode=selectMember">Update Member Information</a>
                     </li>
                     <li class = "nav-item menu-link">
                        <a class="nav-link" href="index.php?mode=selectMovie">Update Movie Information</a>
                    </li>
                 </ul>
             </nav>
         </div>

         <?php
            // Define variables and assign their default values
            $mode = ""; // default value for the switch statement
            $parameterValues = null; // default values named parameters
            $pageTitle = ""; // define a title for each output
            $columns = array(); // define an array of column labels for a table header

            try {
                if (isset($_GET['mode'])) {
                    $mode = $_GET['mode'];
                }
                switch ($mode) {
                    case 'updateMemberInfo': // Update selected member
                        include("./model/updateMemberInfo.php");
                        break;

                    case "updateMovieInfo":
                        include("./model/updateMovieInfo.php");
                        break;

                    case "displayMemberInfo":
                        include("./model/displayMemberInfo.php");
                        break;

                    case "displayMovieInfo":
                        include("./model/displayMovieInfo.php");
                        break;

                    case 'addNewMember': // add a new member
                        include("./model/addNewMember.php");
                        break;

                    case "selectMember":
                        include('./model/selectMember.php');
                        break;

                    case "selectMovie":
                        include('./model/selectMovie.php');
                        break;

                    case 'displayNewMemberForm':
                        // Display an HTML form
                        include('./include/displayNewMemberForm.html');
                        break;

                    case "members": // display a list of members
                        include("./model/members.php");
                        break;

                    case "movies": // display a list of movies, based on the selected genre
                        //include("./model/movies.php");
                        include("./model/movies2.php");
                        break;

                    default: // Default page
                        echo "<h3>Welcome to the Online Movie Club<h3>";
                        break;
                }
            } catch (PDOException $e) {
                echo "Error!: " . $e->getMessage() . "<br/>";
                $db = null; // clear connection
                die();
            }
            $db = null; // clear connection
            /* end main section */
            ?>

     </div>
 </body>

 </html>

 <?php
    function displayResultSet($pageTitle, $resultSet, $columns)
    {
        // Use a table structure for displaying data
        echo "<h3>$pageTitle</h3>";

        echo "<table class='table table-sm'>";
        // If the $columns array is not empty then display table header
        $numCols = count($columns); // find the size of the array
        if ($numCols > 0) {
            echo "<thead><tr>";
            foreach ($columns as $c) {
                echo "<th>{$c}</th>";
            }
            echo "</thead>";
        }

        echo "<tbody>";
        foreach ($resultSet as $item) {
            /* Each $item is an associative array.  Keys are the same as the field names 
                    used in the SQL statement.
                */
            // Define a table row for each item in the $resultSet array
            echo "<tr>";

            // We can use a foreach loop to access each element of $item array
            foreach ($item as $key => $value) {
                echo "<td>{$value}</td>";
            }

            echo "</tr>";
        }
        echo "</tbody></table>";
    }

    function getAll($sql, $db, $parameterValues = null)
    {
        /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object.
    */
        $statement = $db->prepare($sql);

        /* Execute prepared statement. The execute( ) method returns a resource object.  */
        $statement->execute($parameterValues);

        /* Use the fetchAll( ) method to extract records from the result set.
    */
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    ?>