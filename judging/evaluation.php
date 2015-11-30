<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// echo '<p>' . print_r($_SESSION) . '</p>';
// echo '<p>' . $_SERVER["PHP_SELF"] . '</p>';

if (isset($_POST["evaluate"]) && ($_SESSION["isJudge"])){
    //scrub data
    $evaluator = htmlspecialchars(($_POST["evaluator"]));
    $evalRadio = htmlspecialchars(($_POST["evalRadio"]));
    $evalComment = htmlspecialchars(($_POST["evalComments"]));
    $entryid = htmlspecialchars(($_POST["entryid"]));

    //insert eval into table
    $sqlInsert = <<<SQL
    INSERT INTO `tbl_evaluations`
        (`evaluator`,
        `rating`,
        `comment`,
        `entry_id`)
        VALUES
        ('$evaluator',
        $evalRadio,
        '$evalComment',
        $entryid)
SQL;
echo $sqlInsert;
    if (!$result = $db->query($sqlInsert)) {
          db_fatal_error($db->error, $login_name . " -data insert issue- " . $sqlInsert);
          exit($user_err_message);
    } else {
        $db->close();
        unset($_POST['evaluate']);
        $evaluator = $evalRadio = $evalComment = $entryid = null;
        safeRedirect('index.php');
        exit();
    }
}


$entryid = $db->real_escape_string(htmlspecialchars($_GET["evid"]));

$sqlSelect = <<<SQL
    SELECT EntryId,
        title,
        document,
        penName,
        manuscriptType,
        contestName,
        datesubmitted
    FROM vw_entrydetail
    WHERE EntryId = $entryid

SQL;
    if (!$result = $db->query($sqlSelect)) {
        db_fatal_error($db->error, "data select issue", $sqlSelect);
        exit($user_err_message);
    }
  //do stuff with your $result set

    if ($result->num_rows > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>LSA-<?php echo "$contestTitle";?> Writing Contests</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LSA-English Writing Contests">
  <meta name="keywords" content="LSA-English, Hopwood, Writing, UniversityofMichigan">
  <meta name="author" content="LSA-MIS_rsmoke">
  <link rel="icon" href="img/favicon.ico">

  <script type='text/javascript' src='../js/webforms2.js'></script>

  <link rel="stylesheet" href="../css/bootstrap.min.css"><!-- 3.3.1 -->
  <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="../css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="../css/normalize.css" media="all">
  <link rel="stylesheet" href="../css/default.css" media="all">

  <style type="text/css">
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance:textfield;
    }
  </style>
  <base href=<?php echo URL ?>>
</head>

<body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
          <div class="container">
          <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="judging/index.php"><?php echo "$contestTitle";?><span style="color:#00FF80">-Judging</span></a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Signed in as <?php echo $login_name;?><strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="index.php"><?php echo "$contestTitle";?> main</a>
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

    <?php if ($_SESSION["isJudge"]) {
        ?>
  <div class="container"><!-- container of all things -->
  <div class="row clearfix">
    <div class="col-md-12">
        <div>
            <h1>Evaluation</h1>
             <ul>
             <li>Contest rules can be found <a href='http://www.lsa.umich.edu/hopwood/contestsprizes' target='_blank'>here</a></li>
             </ul>
        </div>

         <hr>
<?php
        while ($row = $result->fetch_assoc()) {
            echo "<div style='padding: 0 0 0 40px;'>";
            echo "<strong>Entry Title: </strong><mark>" . $row["title"] . "</mark>  <br />";

            echo '<a href="' . $_SERVER["DOCUMENT_ROOT"] . '/../contestfiles/' . $row['document'] . '">Read</a><br /><br />';

            echo "<strong>Authors Pen-name:</strong> " . $row["penName"] ."<br />";

            echo "<strong>The contest and division entered:</strong> " . $row["contestName"] . " - " . $row["manuscriptType"] . "<br />";

            echo '<strong>Date Submitted Online:</strong> ' . date_format(date_create($row["datesubmitted"]),"F jS Y \a\\t g:ia") . '<br />';

            echo "</div>";

        }
        echo "<hr>";

?>
        <form action="http://writingcontest.dev<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
         <input type="hidden" name="evaluator" value=" <?php echo  $login_name; ?> ">
         <input type="hidden" name="entryid" value=" <?php echo  $entryid; ?> ">
          <div class="radio">
          Rating:<br />
            <label class="radio-inline">
              <input type="radio" name="evalRadio" id="evalRadio1" value="1" required> 1
            </label>
            <label class="radio-inline">
              <input type="radio" name="evalRadio" id="evalRadio2" value="2"> 2
            </label>
            <label class="radio-inline">
              <input type="radio" name="evalRadio" id="evalRadio3" value="3"> 3
            </label>
            <label class="radio-inline">
              <input type="radio" name="evalRadio" id="evalRadio4" value="4"> 4
            </label>
            <label class="radio-inline">
              <input type="radio" name="evalRadio" id="evalRadio5" value="5"> 5
            </label>
            <br />( 1=Lowest rating  to 5=Highest rating )
          </div>
          <div class="form-group">
            <label for="evalComments">Comments</label>
            <textarea class="form-control" id="evalComments" name="evalComments" required></textarea>
          </div>
          <button type="submit" class="btn btn-success" name="evaluate">Submit Evaluation</button>
        </form>
<?php
    } else {
        echo "Nothing to show!";
    }

} else {
?>

  <!-- if there is not a record for $login_name display the basic information form. Upon submitting this data display the contest available section -->
  <div id="notAdmin">
    <div class="row clearfix">
      <div class="col-md-12">

          <div id="instructions" style="color:sienna;">
            <h1 class="text-center" >You are not authorized to this space!!!</h1>
            <h4>University of Michigan - LSA Computer System Usage Policy</h4>
            <p>This is the University of Michigan information technology environment. You
            MUST be authorized to use these resources. As an authorized user, by your use
            of these resources, you have implicitly agreed to abide by the highest
            standards of responsibility to your colleagues, -- the students, faculty,
            staff, and external users who share this environment. You are required to
            comply with ALL University policies, state, and federal laws concerning
            appropriate use of information technology. Non-compliance is considered a
            serious breach of community standards and may result in disciplinary and/or
            legal action.</p>
            <div style="postion:fixed;margin:10px 0px 0px 250px;height:280px;width:280px;"><a href="http://www.umich.edu"><img alt="University of Michigan" src="img/michigan.png" /> </a></div>
          </div><!-- #instructions -->
      </div>
    </div>
  </div>

    <?php
}
    include("footer.php");?>
    <!-- //additional script specific to this page -->
      <script src="judging/jdgJS/jdgMyScript.js"></script>
</div><!-- End Container of all things -->
</body>
</html>

<?php
  $db->close();