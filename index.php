<?php
// Remove comment below to redirect site to temp on-hold page
// header('location:h-index.php');
//         exit();

require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

$userName = ldapGleaner($login_name);
$hasApplicantDetails = false;

    $sqlSelect = <<<SQL
    SELECT uniqname
    FROM tbl_applicant
    WHERE uniqname = '{$login_name}'
SQL;

if (!$result = $db->query($sqlSelect)) {
        db_fatal_error("data insert issue", $db->error);
        exit;
}
  //do stuff with your $result set

if ($result->num_rows > 0) {
    $hasApplicantDetails = true;
}
     $db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <title>LSA-<?php echo "$contestTitle";?> Writing Contests</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LSA-English Writing Contests">
  <meta name="keywords" content="LSA-English, Hopwood, Writing, UniversityofMichigan">
  <meta name="author" content="LSA-MIS_rsmoke">
  <link rel="icon" href="img/favicon.ico">

  <script type='text/javascript' src='js/webforms2.js'></script>

  <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"><!-- 3.3.1 -->
  <link type="text/css" rel="stylesheet" href="css/bootstrap-theme.min.css">

  <link rel="stylesheet" href="css/jquery-ui.min.css">
  <link rel="stylesheet" href="css/jquery-ui.structure.min.css">
  <link rel="stylesheet" href="css/jquery-ui.theme.min.css">

  <link type="text/css" href="css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">
  <link type="text/css" rel="stylesheet" href="css/normalize.css" media="all">
  <link type="text/css" rel="stylesheet" href="css/default.css" media="all">
</head>

<body>
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

	<div class="container"><!--Container of all things -->
<?php
if ($hasApplicantDetails) {
?>
	    <div class="modal fade" id="utility" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      <div class="modal-dialog ">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	            <h5 class="modal-title" id="myModalLabel">Rules and Awards</h5>
	          </div>
	          <div class="modal-body" id="utility_body">
	            <p>One fine body&hellip;</p>
	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
	          </div>
	        </div>
	      </div>
	    </div>


		<!-- CONTESTS AVAILABLE -->
		<!-- if there is a record for the logged in user in the database then display contests available -->
			<div class="row clearfix">
				<div class="col-md-12 column">
				    <h3 class="text-left">The <?php echo $contestTitle; ?> hosts a variety of contests and prizes for students at the University of Michigan.</h3>
					<dl>
						<dt>
							Hopwood Contests
						</dt>
						<dd>
							There are three Hopwood Contests held throughout the year. These Hopwood Contests require enrollment in a qualifying writing course.
							</dd>
						<dt>
							Other Contests
						</dt>
						<dd>
							In addition to the contests noted above, the Hopwood Program administers three fellowship contests and six poetry contests.
						</dd>
					</dl>
		    	</div>
		    </div>
            <div id="instructions">
                <div class="row clearfix">
                    <div class="col-md-12 column">
                    <h3>Instructions:</h3>
                    <ol>
                    <li>Select the apply button, <i>it looks like this</i> ( <span class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-pencil"></span></span> ), next to the contest you would like to enter.</li>
                    <li>Completely fill in the form that opens up and select the upload button, <i>it looks like this</i> ( <span class="btn btn-success btn-xs" disabled="disabled">Upload Application</span> )</li>
                    <li>Select the details button next to your entry below, <i>it looks like this</i> ( <span class="btn btn-warning btn-xs" disabled="disabled"><span class="glyphicon glyphicon-file"></span></span> ), to view the complete details of your entry submission.</li>
                    </ol>
                    <ul>
                    <li><i>NOTE: Be sure your profile is up to date before submitting your entry.</i></li>
                    <li><i>NOTE: You will need to upload a separate application for each genre in the Hopwood Contest and poem in the Rapaport Contest.</i></li>
                    </ul>
                    </div>
                </div>
            </div>
		    <!-- Contest history: display the contests that the logged in user has applied to -->
			<div id="appHistory">
				<div class="row clearfix">
					<div class="col-md-12 column">
					    <h4 class="text-left text-muted">These are the contests that you have submitted to:</h4>
					    <div id="currentEntry"></div>
					</div>
				</div>
			</div>
			<div id="contestList">
				<div class="row clearfix">
					<div class="col-md-12 column">
					    <h4 class="text-left text-muted">These are the contests currently available to you:</h4>
					    <a href="detailEdit.php" class="btn btn-info btn-xs" type="button">keep your profile up to date</a>
					    <div id="availableEntry"></div>
					</div>
				</div>
			</div>

<?php
} else {
?>
		<!-- if there is not a record for $login_name display the basic information form. Upon submitting this data display the contest available section -->
  <form id="formBasicInfo" action="insertApplicant.php" method="post">
		<div id="basicInfo" >
			<div class="row clearfix">
				<div class="col-md-12 column">
				<h4 class="text-left text-muted">Before you can apply for a contest you need to enter some basic information about yourself</h4>


    				    <h5>NAME:</h5>
    				    <label for="userFname" >First name</label>
    				    <input class="form-control" type="text" tabindex="100" required name="userFname" value="<?php echo $userName[0];?>" autofocus />
    				    <label for="userLname">Last name</label>
    				    <input class="form-control" type="text" tabindex="110"required name="userLname" value="<?php echo $userName[1];?>" />
    				    <label for="umid">UMID</label>
    				    <input class="form-control" type="text" placeholder="enter your 8 digit UMID - example: 12345678" tabindex="120" required name="umid" pattern="(^\d{8}$)" title="enter an 8 digit UMID" />
    				    <label for="emailAddress">Campus eMail<br />
    				    <?php echo $login_name . "@umich.edu";?></label>
    				    <input class="form-control" type="hidden" required name="uniqname" value="<?php echo $login_name;?>" />

    				    <h5>ADDRESS:</h5>
    				    <h6>Local(campus)</h6>
    				    <label for="streetL">Street</label>
    				    <input class="form-control" type="text" tabindex="130" required name="streetL" />
    				    <label for="cityL">City</label>
    				    <input class="form-control" type="text" tabindex="140" required name="cityL" />
    				    <label for="stateL">State</label>
    				      <select class="form-control bfh-states" tabindex="150" name="stateL" data-country="US" data-state="MI"></select>
    				    <label for="zipL">Zip</label>
    				    <input class="form-control" type="text" tabindex="160" required name="zipL" pattern="(^[0-9]{5}$)" title="enter a 5 digit zipcode" />
    				    <label for="usrtelL">Phone</label>
    				    <input class="form-control" type="text" tabindex="170" name="usrtelL" data-format="ddd-ddd-dddd"/>
    				<br />
    				    <h6>Hometown: <button id="sameAddress" class="btn btn-xs">or use campus address</button></h6>
    				    <label for="streetH">Street</label>
    				    <input class="form-control" type="text" tabindex="180" required name="streetH" />
    				    <label for="cityH">City</label>
    				    <input class="form-control" type="text" tabindex="190" required name="cityH" />
    				    <label for="stateH">State</label>
    				      <select class="form-control bfh-states" tabindex="200" required name="stateH" data-country="US" data-state="MI"></select>
    				    <label for="zipH">Zip</label>
    				    <input class="form-control" type="text" tabindex="210" required name="zipH" pattern="(^[0-9]{5}$)" title="enter a 5 digit zipcode"/>
    				    <label for="usrtelH">Phone</label>
    				    <input class="form-control" type="text" tabindex="220" name="usrtelH" data-format="ddd-ddd-dddd" />

    				    <!-- //////////////////////////////// -->
    				<hr>
    				    <h5>ACADEMICS:</h5>
    				    I am a:
    				    <div id="classLevelSelect">
    				      <label class="radio-inline">
    				        <input type="radio" id="inlineRadio1" name="classLevel" required value="9"> Freshman
    				      </label>
    				      <label class="radio-inline">
    				        <input type="radio" id="inlineRadio1" name="classLevel" required value="10"> Sophmore
    				      </label>
    				      <label class="radio-inline">
    				        <input type="radio" id="inlineRadio1" name="classLevel" required value="11"> Junior
    				      </label>
    				      <label class="radio-inline">
    				        <input type="radio" id="inlineRadio1" name="classLevel" required value="12"> Senior
    				      </label>
    				      <label class="radio-inline">
    				        <input type="radio" id="inlineRadio2" name="classLevel" required value="20"> Graduate
    				      </label>
    				    </div>
    				    <label for="school">SCHOOL OR COLLEGE</label>
    				    <input class="form-control" type="text" tabindex="230" required name="school" placeholder="example: LSA" />
    				    <label for="major">Major (if undergraduate)</label>
    				    <input class="form-control" type="text" tabindex="240" name="major" placeholder="example: English" />
    				    <label for="dept">Department (if graduate)</label>
    				    <input class="form-control" type="text" tabindex="250" name ="dept" placeholder="example: Dept. of English Language and Literature" />
    				    <label for="gradYear">Expected graduation date</label>
    				    <input class="date-picker form-control" id="gradYearMonth" tabindex="260" required name="gradYearMonth" />
    				    <label for="degree">Degree</label>
    				    <input class="form-control" type="text" tabindex="270" required name="degree" placeholder="example: Bachelors" />
    				    <label for="finAid">Do you receive NEED-BASED financial aid?&nbsp;&nbsp;</label>
    				    <label class="radio-inline">
    				      <input type="radio" id="inlineRadio1" name="finAid" required value="1"> YES
    				    </label>
    				    <label class="radio-inline">
    				      <input type="radio" id="inlineRadio2" name="finAid" required value="0"> NO
    				    </label><br />
    				    <label for="finAidDesc">Details:</label>
    				    <input class="form-control" type="textarea" name="finAidDesc" placeholder="In what years and terms did you recieve aid"/>

    				    <!-- //////////////////////////////// -->

    					<hr>
    				    <h5>PUBLICITY:</h5>
    				    <label for="namePub">Entrant's name as it should appear in publicity</label>
    				    <input class="form-control" type="text" tabindex="280" name="namePub" value="<?php echo $userName[0] . " " . $userName[1];?>"/>
    				    <label for="homeNewspaper">Name of your hometown newspaper</label>
    				    <input class="form-control" type="text" tabindex="290" name="homeNewspaper"  placeholder="example: The Times-Argus" />
    				    <label for="penName">Do you have a preferred pen name? <a href="http://www.plot-generator.org.uk/pen-name/" target="_blank"><small>Try the Pen Name Generator</small></a></label>
    				    <input class="form-control" type="text" tabindex="300" name="penName" placeholder="example: Sarah Bellum" />
    				</div>
    			</div>
    		</div>
    				    <!-- //////////////////////////////// -->
    		<div class="row clearfix">
    			<div class="col-md-12 column">
    			    <div class="well well-sm">
    			    	<button type="submit" id="applyBasicInfo" class='btn btn-sm btn-success applyBtn center-block'>Submit</button><a id='cancel' class="btn btn-xs btn-warning center-block" href="index.php">Cancel</a>
    			    </div>
    			</div>
    		</div>
  </form>

	</div><!-- End Container of all things -->
<?php
}
  include("footer.php");
?>

</body>
</html>
