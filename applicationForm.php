<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');


if (isset($_POST['upload'])) {
        $contestID = htmlspecialchars($_POST['contestID']); //Get id passed, this is the contests id
        // output data of each row

        // this comes from the radio buttons selecting category name
        $categoryID = htmlspecialchars($_POST['categoryName']);
        $title = $db->real_escape_string(htmlspecialchars($_POST["title"]));
        $documentName = $_SERVER["REQUEST_TIME"] . "_" . $title . "_" . $login_name;
        //if the contest requires enter the value otherwise enter default NoValue
        $courseNameNum = (strlen($db->real_escape_string(htmlspecialchars($_POST["courseNameNum"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["courseNameNum"])) : "NoValue" );
        $instrName = (strlen($db->real_escape_string(htmlspecialchars($_POST["instrName"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["instrName"])) : "NoValue" );
        $termYear = (strlen($db->real_escape_string(htmlspecialchars($_POST["termYear"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["termYear"])) : "NoValue" );
        $recLetter1Name = (strlen($db->real_escape_string(htmlspecialchars($_POST["recLetter1Name"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["recLetter1Name"])) : "NoValue" );
        $recLetter2Name = (strlen($db->real_escape_string(htmlspecialchars($_POST["recLetter2Name"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["recLetter2Name"])) : "NoValue" );

        $sqlApplicant = "SELECT id, classLevel FROM tbl_applicant WHERE uniqname = '$login_name' ";
        $resApplicant = $db->query($sqlApplicant);
    if ($resApplicant->num_rows > 0) {
        // output data of each row
        while ($row = $resApplicant->fetch_assoc()) {
            $applicantID =  $row["id"];
                $classLevelID =  $row["classLevel"];
        }
    } else {
            $applicantID = "failure";
    }

        $sqlInsert = <<<SQL
        INSERT INTO `tbl_entry`
      (`contestID`,
      `applicantID`,
      `categoryID`,
      `classLevelID`,
      `title`,
      `documentName`,
      `courseNameNum`,
      `instrName`,
      `termYear`,
      `recLetter1Name`,
      `recLetter2Name`,
      `created_by`)
      VALUES
      ($contestID,
      $applicantID,
      $categoryID,
      $classLevelID,
      '$title',
      '$documentName',
      '$courseNameNum',
      '$instrName',
      '$termYear',
      '$recLetter1Name',
      '$recLetter2Name',
      '$login_name')
SQL;
    if (!$result = $db->query($sqlInsert)) {
        //db_fatal_error($errorMsg, $msg = "ERROR: ", $queryString = "queryString")
          db_fatal_error($db->error, "data insert issue", $sqlInsert);
          exit();
    }
        $db->close();
        unset($_POST['upload']);
        header('location:index.php');
        exit();

}

//Get id passed, this is the contests id
if (!empty($_GET['id'])) {
    $contestID = htmlspecialchars($_GET['id']);

    $sqlSelect = <<<SQL
    SELECT lk_contests.name, lk_contests.id
    FROM lk_contests where lk_contests.id =  (
                  SELECT contestsid
                  FROM tbl_contest
                  WHERE tbl_contest.id = '{$contestID}'
                  )
SQL;

    $res = $db->query($sqlSelect);
    if ($res->num_rows > 0) {
    // output data of each row
        while ($row = $res->fetch_assoc()) {
            $contestName = $row["name"];
            $contestsID = $row["id"]; //get the tbl_contests id of the contest
        }
    } else {
        $contestName = "Error: Could not resolve (get) contest name";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <title>LSA-<?php echo "$deptLngName";?> Writing Contests</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LSA-English Writing Contests">
  <meta name="keywords" content="LSA-English, Hopwood, Writing, UniversityofMichigan">
  <meta name="author" content="LSA-MIS_rsmoke">
  <link rel="icon" href="img/favicon.ico">

  <script type='text/javascript' src='js/webforms2.js'></script>

  <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="css/normalize.css" media="all">
  <link type="text/css" rel="stylesheet" href="css/default.css" media="all">
<!--   <link href="css/form.css" rel="stylesheet" type="text/css"> -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
  <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> <a class="navbar-brand" href="index.php">
        <?php echo "$contestTitle";?></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown">Signed in as <?php echo $login_name;?><strong class="caret"></strong></a>
          <ul class="dropdown-menu">
            <li>
              <a href="detailEdit.php">Profile</a>
            </li>
            <li class="divider">
            </li>
            <li>
              <a href="https://weblogin.umich.edu/cgi-bin/logout">logout</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  </nav>


  <div class="row clearfix">
    <div class="col-md-12">
    <section>
      <header>
        <h3><?php echo $contestName; ?></h3>
      </header>
      <article>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <input class="form-control" type="hidden" required name="contestID" value="<?php echo $contestID; ?>" >
    <?php
    switch ($contestsID) {
        case 1: //falls through
        case 2: //falls through
        case 3:
              echo '<div id="hopwoodTemplate">';
                echo '<h5>ACADEMICS</h5>';
                echo '<label for="courseNameNumber">Qualifying Course (DEPARTMENT AND COURSE #)</label>';
                echo '<input class="form-control" type="text" required name="courseNameNum" placeholder="example: eng216" />';
                echo '<label for="instrName">Name of Instructor</label>';
                echo '<input class="form-control" type="text" required name="instrName" placeholder="example: Petra Kuppers" />';
                echo '<label for="termYear">Term and Year Taken</label>';
                echo '<input class="form-control" type="text" required name="termYear" placeholder="example: Fall-2014" />';
              echo '</div>';
            break;
        case 12:
               echo '<div id="millerTemplate">';
                echo '<label for="recLetter1">Name of faculty submitting first letter of recommendation (or e-mail)</label>';
                echo '<input class="form-control" type="text" required name="recLetter1Name" placeholder="example: Petra Kuppers" />';
                echo '<label for="recLetter2">Name of faculty submitting second letter of recommendation (or e-mail)</label>';
                echo '<input class="form-control" type="text" required name="recLetter2Name" placeholder="example: Alisse Portnoy" />';
              echo '</div>';
            break;
    }
        ?>

        <label for="title">Title of submission</label>
        <input class="form-control" type="text" required name="title" />


        <p>Please select a manuscript type:</p>

          <div id="radioSelectFor<?php echo $contestName; ?>">
    <?php //select what the application category(novel, poetry, fiction etc) is for the submission by
            //taking the contests id and doing a lookup on link_contestsTocategory
    switch ($contestsID) { //What contests id is being submitted to
        case 1: // it would be categoryID 1 2 3 4 5
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required disabled >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required >Fiction</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" required disabled >Novel</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required >Nonfiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required >Poetry</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required disabled >Screenplay</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" required disabled >Shortfiction</label>';
            break;
        case 2:
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required disabled >Fiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" required >Novel</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required >Nonfiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required >Poetry</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" required >Shortfiction</label>';
            break;
        case 3: //it would be categoryID 1 or 2 build select statement
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required >Fiction</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" required disabled >Novel</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required >Nonfiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required >Poetry</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" required disabled >Shortfiction</label>';
            break;
          //5,6,7,8,9,15 are all poetry only apps so they are default setting

        case 10: // it would be categoryID 1 2 3 4 5
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required >Fiction</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" required disabled >Novel</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required >Nonfiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required >Poetry</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" required disabled >Shortfiction</label>';
            break;
        case 11: //it would be categoryID 1 or 2 build select statement
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required disabled >Fiction</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" required disabled >Novel</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required disabled >Nonfiction</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required disabled >Poetry</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" required disabled >Shortfiction</label>';
            break;
        case 12: //it would be categoryID 1 or 2 build select statement
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required >Fiction</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" required disabled >Novel</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required disabled >Nonfiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required >Poetry</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" required disabled >Shortfiction</label>';
            break;
        default:
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required disabled >Drama</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required disabled >Fiction</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" required disabled >Novel</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required disabled >Nonfiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" checked required >Poetry</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required disabled >Screenplay</label>';
            //echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" required disabled >Shortfiction</label>';
    };
            ?>
          </div>
          <p>
          <input class="btn btn-default" type="submit" name="upload" value="Upload Application">
          </p>
         </form>
    </article>
    </section>
    </div>
  </div>
</div><!-- class="container" -->

<!-- if there is not a record display this stuff -->
<?php include("footer.php");?>

</body>
</html>