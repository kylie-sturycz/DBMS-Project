    <div class="container">
      <?php
      //include_once("pdo_connect.php");
      $options = getOptions($db);
      addLinks($options); //get all movie types and create <a> elements to show all movie types
      $selected = isset($_GET['movieType']) ? $_GET['movieType'] : "";
      ?>
      <form action="index.php" method='get'>
        <input type="hidden" name="mode" value="movies" />
        <label for='movieType'>Choose a Movie Type: </label>
        <select name="movieType" class="listItem" id="movieType">
          <?php
          echo "<option value='All'>All</option>";
          foreach ($options as $option) {
            if ($selected == $option)
              echo "<option value='$option' selected>$option</option>";
            else
              echo "<option value='$option'>$option</option>";
          }
          ?></select>
        <p><input type='submit' name='submit1' value="Search" class='btn btn-primary'>
      </form>
    </div>
    <?php
    //When user clicks the links, add genre data in URL query string
    //then the request is get back to index.php with the mode and genre data
    //process the request with genre data here
    $movieGenre = isset($_GET['genre']) ? $_GET['genre'] : "";
    //var_dump($movieGenre);
    if (!empty($movieGenre)) {
      getMovieList($db, $movieGenre);
    }

    //step-1: add php here to get movie list by the movie type that user selected from drop down list
    //if drop-down menu option is selected by user and user clicked submit1 button
    if (isset($_GET['movieType']) && isset($_GET['submit1'])) {
      $selected = trim($_GET['movieType']);
      getMovieList($db, $selected);
    }

    //step-2: add php here to get movie list by the years that user entered in the years input boxes
    if (isset($_GET['year1']) && isset($_GET['year2']) && isset($_GET['submit2'])) {
      $year1 = (int)$_GET['year1'];
      $year2 = (int)$_GET['year2'];
      $movieYear = [$year1, $year2];
      getMovieListByYear($db, $movieYear);
    } else if (isset($_GET['submit2'])) {
      $movieYear = [1930, 2024];
      getMovieListByYear($db, $movieYear);
    }
    /**
     * getOptions: to get all options (here refers to the movie types
     * from the movies listed in the database movies table)
     */
    function getOptions($db)
    {
      $sql = "SELECT `type` FROM `movies`";
      $type = getAll($sql, $db);
      $options = [];
      //print_r($type);
      foreach ($type as $t)
        $options[] = $t['type'];
      //print_r($options);
      $options = array_unique($options);
      return $options;
    }

    /**
     * addLinks: to display all movie types as hyperlink <a> elements on the page
     */
    function addLinks($options)
    {
      //print_r($options);
      $links = "<p>Choose a movie genre:";
      $links .= "<a href='?mode=movies&genre=All'>All Movies</a>";
      foreach ($options as $genre) {
        //print_r($genre);
        $links .= "<a href='?mode=movies&genre=$genre'>$genre Movies</a>";
      }
      $links .= "</p>";
      echo $links;
    }

    function getMovieListByYear($db, $movieYear)
    {
      try {
        // Define the SQL statement
        $sql = "SELECT * FROM `movies` where `year`>= :year1 AND `year` <= :year2";
        $parameterValue = array(":year1" => min($movieYear), ":year2" => max($movieYear));
        $movieList = getAll($sql, $db, $parameterValue);

        print_r($movieList[0]);
        $colNames = array_keys($movieList[0]);
        //print_r($colNames);
        // Use a table structure for displaying data
        echo "<h3>List of " . min($movieYear) . "-" . max($movieYear) . " Movies</h2>";
        displayTable($movieList);
      } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        die();
      }
    }


    function getMovieList($db, $movieGenre)
    {
      try {
        // Define the SQL statement
        if ($movieGenre == "All") {
          $sql = "SELECT * FROM `movies` ";
          $movieList = getAll($sql, $db);
        } else {
          $sql = "SELECT * FROM `movies` where `type`= :type";
          $parameterValue = array(":type" => $movieGenre);
          $movieList = getAll($sql, $db, $parameterValue);
        }
        //print_r($movieList[0]);
        $colNames = array_keys($movieList[0]);
        //print_r($colNames);
        $countMovies = count($movieList);
        // Use a table structure for displaying data
        echo "<h3>List of $countMovies $movieGenre Movies</h3>";
        displayTable($movieList);
      } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        die();
      }
    }

    function displayTable($movieList)
    {
      //print_r($movieList[0]);
      $colNames = array_keys($movieList[0]);
      //print_r($colNames);
      // Use a table structure for displaying data
      echo "<table class='table'><thead><tr>";
      foreach ($colNames as $col) {
        echo "<th>" . ucfirst($col) . "</th>";
      }
      echo "</thead><tbody>";
      $tr = "";
      foreach ($movieList as $movie) {
        //Each $movie is an associative array. Keys are the same as the field names
        //print_r($movie); //associative array of data row
        $tr .= "<tr>";
        foreach ($movie as $key => $data) {
          //print_r($data);
          $tr .= "<td>$data</td>";
        }
        $tr .= "</tr>";
      }
      echo $tr . "</tbody></table>";
    }

    ?>