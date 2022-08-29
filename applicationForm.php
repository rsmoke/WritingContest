<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

if (isset($_POST['upload'])) {
        $contestID = htmlspecialchars($_POST['contestID']); //Get id passed, this is the contests id

        // this comes from the radio buttons on submission for selecting category name ie. fiction, poetry, screenplay etc
        $categoryID = htmlspecialchars($_POST['categoryName']);
        $title = $db->real_escape_string(htmlspecialchars($_POST["title"]));

        //if the contest requires enter the value otherwise enter default NoValue
        $courseNameNum = (strlen($db->real_escape_string(htmlspecialchars($_POST["courseNameNum"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["courseNameNum"])) : "NoValue" );
        $instrName = (strlen($db->real_escape_string(htmlspecialchars($_POST["instrName"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["instrName"])) : "NoValue" );
        $termYear = (strlen($db->real_escape_string(htmlspecialchars($_POST["termYear"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["termYear"])) : "NoValue" );
        $recLetter1Name = (strlen($db->real_escape_string(htmlspecialchars($_POST["recLetter1Name"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["recLetter1Name"])) : "NoValue" );
        $recLetter2Name = (strlen($db->real_escape_string(htmlspecialchars($_POST["recLetter2Name"]))) > 0 ? $db->real_escape_string(htmlspecialchars($_POST["recLetter2Name"])) : "NoValue" );

        $sqlApplicant = "SELECT id, classLevel FROM tbl_applicant WHERE uniqname = '$login_name' ";
        if(!$resApplicant = $db->query($sqlApplicant)){
          unset($_POST['upload']);
          db_fatal_error("data lookup issue", $db->error, $sqlApplicant, $login_name);
          exit($user_err_message);
        }
        if ($resApplicant->num_rows > 0) {
          // output data of each row
            while ($row = $resApplicant->fetch_assoc()) {
                $applicantID =  $row["id"];
                $classLevelID =  $row["classLevel"];
            }
        } else {
            //no contest matched ID so go back to index to allow user to reselect a contest
            non_db_error("no applicant matched ID! Exited application - Username=> " . $login_name, $login_name);
            exit();
        }
        if ((!empty($_FILES["fileToUpload"])) && ($_FILES['fileToUpload']['error'] == 0) && (strlen(basename($_FILES["fileToUpload"]["name"])) < 250)) {
            $target_dir = $_SERVER["DOCUMENT_ROOT"] . '/../contestfiles/';
            $filename = basename($_FILES["fileToUpload"]["name"]);
            $filename = preg_replace("/[^A-Za-z0-9\.]/", '', $filename);
            $target_file = getUTCTime() . "_" . $filename;
            //added 111215 to fix upload error due to special chars in name
            $target_file = $db->real_escape_string(htmlspecialchars($target_file));
            $target_full = $target_dir . $target_file;
            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $fileType = $_FILES['fileToUpload']['type'];
            $max_file_size = 20971520; //20M

            $uploadOk = 0; //if this value is 0 the file will not upload. After all check pass it will set to 1.
            $fileErrMessage = "<strong>Use your browser's back button and correct the following errors: </strong>";

            // Check if file already exists
            if (file_exists($target_full)) {
                $fileErrMessage = $fileErrMessage . " <br />=>Sorry, that file already exists.";
            }
            // Check file size is not larger than allowable
            if ($_FILES["fileToUpload"]["size"] > $max_file_size) {
                $fileErrMessage = $fileErrMessage . " <br />=>Sorry, your file was too large.";
            }
            // Allow only pdf file format and change uploadOK to 1 if TRUE
            if ((($fileType == "application/pdf") || ($fileType == "application/vnd.adobe.pdf")) && ($ext == 'pdf')) {
                $uploadOk = 1;
            } else {
                $fileErrMessage = $fileErrMessage . " <br />=>Sorry, only PDF files are allowed. This is a " . $fileType . " with the extension of " . $ext;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $fileErrMessage = $fileErrMessage . " <br />=>Your file was not uploaded. Confirm the file is 20 megabytes or less and in PDF format.";
                $target_file = "empty";
                non_db_error($fileErrMessage . "Username=> " . $login_name, $login_name);
                exit($user_err_message . "<br />" . $fileErrMessage);
            } else {
                // if everything is ok, try to upload file
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_full)) {
                    echo "The file ". $target_file . " has been uploaded.";
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
                          '$target_file',
                          '$courseNameNum',
                          '$instrName',
                          '$termYear',
                          '$recLetter1Name',
                          '$recLetter2Name',
                          '$login_name')
SQL;
                    if (!$result = $db->query($sqlInsert)) {
                          db_fatal_error("Data insert issue- " . $fileErrMessage, $db->error, $sqlInsert, $login_name);
                          exit($user_err_message);
                    } else {
                        unset($_POST['upload']);
                        $_SESSION['flashMessage'] = "<span class='text-success'>- Successful submission -</span>";
                        safeRedirect('index.php');
                        exit();
                    }
                } else {
                    $target_file = "empty";
                    $fileErrMessage = $fileErrMessage . " - Sorry, there was an error uploading your file.";
                    non_db_err($fileErrMessage . " - Username=> " . $login_name);
                    exit();
                }
            }
        } else {
            $target_file = "empty";
            $fileErrMessage = $fileErrMessage . " - no file information - ";
            non_db_error($fileErrMessage . " Username=> " . $login_name, $login_name);
            exit($user_err_message);
        }
}

//Since $_POST is not set this page display the contest entry form so Get id passed, this is the contests id
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

    if(!$res = $db->query($sqlSelect)){
      db_fatal_error("Error: Could not resolve (get) contest name", $db->error, $sqlSelect, $login_name);
      exit($user_err_message);
    }
    if ($res->num_rows > 0) {
    // output data of each row
        while ($row = $res->fetch_assoc()) {
            $contestName = $row["name"];
            $contestsID = $row["id"]; //get the tbl_contests id of the contest
        }
    } else {
      //no contest matched ID so go back to index to allow user to reselect a contest
      non_db_error("no contest matched ID! sent user back to index to allow them to reselect a contest. Username=> " . $login_name, $login_name);
      safeRedirect('index.php');
      exit();
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

        <input class="form-control" type="hidden" required name="contestID" value="<?php echo $contestID; ?>" >
    <?php
    switch ($contestsID) {
        case 1: //falls through
        case 2: //falls through
        case 3: //falls through
        case 17: //falls through
        case 18: //falls through
        case 19: //falls through
        case 20: //falls through
        case 21: //falls through
        case 22: //falls through
        case 23: //falls through
        case 24: //falls through
        case 25: //falls through
        case 26: //falls through
              echo '<div id="hopwoodTemplate">';
                echo '<h5>ACADEMICS</h5>';
                echo '<h5 class="bg-warning"><span class="text-info">NOTICE:</span> There is no longer a requirement to upload transcripts</h5><br>';
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
        // Do I need a default here?
    }
        ?>

        <label for="title">Title of submission</label>
        <input class="form-control" type="text" required name="title" />


        <label for="categoryName">Please select a manuscript type:</label>

          <div id="radioSelectFor<?php echo $contestName; ?>">
    <?php //select what the application category(novel, poetry, fiction etc) is for the submission by
            //taking the contests id and doing a lookup on link_contestsTocategory
    switch ($contestsID) { //What contests id is being submitted to
        case 17: //falls through
        case 21: //falls through
        case 24: //falls through
        case 27: // it would be categoryID 3
        case 34:
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" checked required >Nonfiction</label>';
            break;
        case 18:
        case 31:
        case 32: // it would be categoryID 4
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" checked required >Fiction</label>';
            break;
        case 2:  //it would be categoryID 2
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" checked required >Screenplay</label>';
            break;
        case 30: //it would be categoryID 1 2
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            break;
        case 10: // it would be categoryID 1 2 3 4 5
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required >Fiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="3" required >Nonfiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required >Poetry</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            break;
        case 11: //it would be categoryID 1 or 2 build select statement
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            break;
        case 12: //it would be categoryID 1 2 4 or 5 build select statement
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" required >Drama</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="4" required >Fiction</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" required >Poetry</label>';
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="2" required >Screenplay</label>';
            break;
        case 19:  //it would be categoryID 6
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="6" checked required >Novel</label>';
            break;
        case 20:  //it would be categoryID 1
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="1" checked required >Drama</label>';
            break;
        case 22: // falls through
        case 25: // falls through
        case 28: //it would be categoryID 7
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="7" checked required >Shortfiction</label>';
            break;
        case 35: //it would be categoryID 8
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="8" checked required >Text-Image_Composition</label>';
            break;
        default: //5,6,7,8,9,15,29,33 are all poetry only apps so they are default setting it would be categoryID 5
            echo '<label class="radio-inline"><input type="radio" name="categoryName" value="5" checked required >Poetry</label>';
    };
            ?>
          </div>
          <div class="form-group fileUpload-group">
            <label class="control-label" for="fileToUpload">Select file to upload (it must be in PDF format):</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
            <input type="file" name="fileToUpload" id="fileToUpload" required />
            <span id="helpBlock2" class="help-block">Title (or first) page of pdf should be <strong><em>title of your manuscript, pen-name</em></strong> and <strong><em>contest and division entered (e.g. Hopwood Poetry)</em></strong> only.</span>
          </div>
          <div class='text-center'>
          <input class="btn btn-success" type="submit" name="upload" value="Upload Application">
          </div>
         </form>
    </article>
    </section>
    </div>
  </div>
</div><!-- class="container" -->

<!-- if there is not a record display this stuff -->
<?php include("footer.php");?>
<script>
var uploadField = document.getElementById("fileToUpload");

uploadField.onchange = function() {
    if(this.files[0].size > 20971520){
       alert("Your file is too big!");
       this.value = "";
    };
};
</script>

</body>
</html>
<?php
} else {
  //"no ID in url so go back to index to allow user to reselect a contest"
  non_db_error("no ID in url! sent user back to index to allow them to reselect a contest. Username=> " . $login_name, $login_name);
  safeRedirect('index.php');
  exit();
}
?>
