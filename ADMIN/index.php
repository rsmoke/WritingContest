<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

$isAdmin = false;


$sql = <<< _SQL
  SELECT * 
  FROM tbl_contestAdmin 
  WHERE uniqname = '$login_name' 
  ORDER BY uniqname
_SQL;

$resAdmin = $db->query($sql);

if ($db->error) {
    try {
        throw new Exception("MySQL error $db->error <br> Query:<br> $sql", $db->errno);
    } catch (Exception $e) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}

if ($resAdmin->num_rows > 0) {
    $isAdmin = true;
    if (isset($_GET['delete'])) {
        $result = $db->query('DELETE FROM tbl_contestAdmin WHERE id = '.(int)$_GET['delete']);
    }

}

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
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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
  <base href="http://localhost/~rsmoke/WritingContest/">
</head>

<body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
          <div class="container">
          <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="ADMIN/index.php"><?php echo "$contestTitle";?><span style="color:#FF4B4B">-ADMIN</span></a>
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

    <?php if ($isAdmin) {
        ?>
  <div class="container"><!-- container of all things -->
  <div class="row clearfix">
    <div class="col-md-12">

      <div class="btn-toolbar pagination-centered" role="toolbar" aria-label="admin_button_toolbar">
      <div class="btn-group" role="group" aria-label="contest_applicant">
        <button id="admContestBtn" type="button" class="btn btn-primary">Contest</button>
        <button id="admApplicantBtn" type="button" class="btn btn-primary">Applicant</button>
      </div>
      <div class="btn-group" role="group" aria-label="contests_manuscript_type">
        <button id="admContestsBtn" type="button" class="btn btn-info">Contests Administration</button>
        <button id="admManuscriptTypeBtn" type="button" class="btn btn-info">Manuscript Types</button>
      </div>
      <div class="btn-group" role="group" aria-label="admin_access">
        <button id="admAdminManageBtn" type="button" class="btn btn-default">Admin-Access</button>
      </div>
      </div>
    </div>
  </div>

<div id="initialView">
  <div class="row clearfix">
    <div class="col-md-12">
    <div><img src="ADMIN/admIMG/IMG_0970.jpg" class="img img-responsive center-block" width="571" height="304" alt="Hopwood Image"></div>
    </div>
  </div>  
</div>
 
<div id="contest">
  <div class="row clearfix">
    <div class="col-md-12">
    <h5 class="text-muted">Please select a contest that you want to view</h5>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h6 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              Hopwood Underclassmen ----->  opened: 2014-09-14 00:00:00 - closed: 2014-12-20 00:00:00
            </a>
          </h6>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
             <div class="well well-sm">Eligibility: Fr So</div>
             <div class="table-responsive">
              <table class="table table-hover table-condensed">
                <thead>
                <tr>
                  <th>AppID</th><th>Applicant Name</th><th>uniqname</th><th>Title</th><th>Docuement Name</th><th>Date Entered</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td>1</td><td>Richard Smoke</td><td>rsmoke</td><td>The Story of programming</td><td>documentname-1418600132.pdf</td><td>2014-12-01 18:17:13</td></tr>
                  <tr><td>1</td><td>Mary Doogan</td><td>maryd</td><td>my songs of prose</td><td>documetName-1418678492.docx</td><td>2014-12-01 18:17:13</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

       <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
          <h6 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              The Arthur Miller Award ----->  opened: 2014-09-14 00:00:00 - closed: 2014-12-20 00:00:00
            </a>
          </h6>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="panel-body">
             <div class="well well-sm">Eligibility: So Jr</div>
             <div class="table-responsive">
              <table class="table table-hover table-condensed">
                <thead>
                  <th>AppID</th><th>Applicant Name</th><th>uniqname</th><th>Title</th><th>Docuement Name</th><th>Date Entered</th>
                </thead>
                <tbody>
                  <tr><td>1</td><td>Richard Smoke</td><td>rsmoke</td><td>The Story of programming</td><td>documentname-1418600132.pdf</td><td>2014-12-01 18:17:13</td></tr>
                  <tr><td>1</td><td>Mary Doogan</td><td>maryd</td><td>my songs of prose</td><td>documetName-1418678492.docx</td><td>2014-12-05 10:54:13</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
          <h6 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              The Roy W. Cowden Memorial Fellowship ----->  opened: 2014-09-14 00:00:00 - closed: 2014-12-20 00:00:00
            </a>
          </h6>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
          <div class="panel-body">
             <div class="well well-sm">Eligibility: Fr So Jr Sr</div>
             <div class="table-responsive">
              <table class="table table-hover table-condensed">
                <thead>
                <tr>
                  <th>AppID</th><th>Applicant Name</th><th>uniqname</th><th>Title</th><th>Document Name</th><th>Date Entered</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>    
    </div>
  </div>  
</div>

<div id="applicant">
  <div class="row clearfix">
    <div class="col-md-12">
    <h5 class="text-muted">Please select an applicant</h5>
    <p>By clicking on the applicants uniqname you can see their complete profile</p>
    <span id="allApplicants">
        <?php
          $resApp = $db->query("SELECT * FROM tbl_applicant ORDER BY userLname");
        while ($row = $resApp->fetch_assoc()) {
            echo '<div class="record" id="record-' . $row['id'] . '"><strong>' . $row['uniqname'] .'</strong>  -- ' . $row['userLname'] .  ", " . $row['userFname'] .  "&nbsp;" . $row['umid'] . '</div>';
        }
        ?>
    </span>
  
    </div>
  </div>  
</div>

<div id="manuscript_type">
  <div class="row clearfix">
    <div class="col-md-12">
    <h5>Select to edit</h5>
      <span class="allManuscripts">
            <?php
            $resManuscript = $db->query("SELECT * FROM lk_category ORDER BY name");
            while ($row = $resManuscript->fetch_assoc()) {
                echo '<div class="record" id="record-' . $row['id'] . '">
              <strong>' . $row['name'] .'</strong>  -- ' . $row['desc'] . '</div>';
            }
        ?>
      </span>
    </div>
  </div>  
</div>

<div id="contests">
  <div class="row clearfix">
    <div class="col-md-12">
    <div class="btn-toolbar" role="toolbar" aria-label="contest_button_toolbar">
      <div class="btn-group" role="group" aria-label="contests_management">
        <button id="addContest" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Click to create a new instance of one of the contests listed below">Add New Contest Instance</button>
        <button id="addContestsType" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Click to create a new contests area">Add New Contest Type</button>
      </div>
      </div>
      <span class="allContests">
        <?php
          $resContests = $db->query("SELECT * FROM lk_contests ORDER BY name");
        while ($row = $resContests->fetch_assoc()) {
            echo '<div class="record" id="contests">
            <strong><span data-contestsid="' . $row['id'] . '" class="btn btn-link editBtn" type="button">' . $row['name'] .'</span></strong>  -- ' . $row['contests_notes'] . '</div>';
        }
        ?>
    </span>
    <br>
    <span class="allOpenContests">
    <h5>These are the currently open contests</h5>
        <?php
          $resOpenContests = $db->query("SELECT * FROM vw_contestlistingDated ORDER BY ContestsName");
        if (!$resOpenContests) {
            echo "There are no open contests";
        } else {
            while ($instance = $resOpenContests->fetch_assoc()) {
                echo '<div class="record"><strong>' . $instance.ContestsName . '</strong> Opened: ' . $instance.date_open . ' - Closes: ' . $instance.date_closed . '</div>';
            }
        }
        ?>
    </span>
    <br>
    <span class="allOpenContests">
    <h5>These are the contests set to open in the future</h5>
        <?php
          $resOpenContests = $db->query("SELECT * FROM vw_contestlistingfuturedated ORDER BY ContestsName");
        if (!$resOpenContests) {
            echo "There are no open contests";
        } else {
            while ($instance = $resOpenContests->fetch_assoc()) {
                echo '<div class="record"><strong>' . $instance['ContestsName'] . '</strong> Opens: ' . $instance['date_open'] . ' - Closes: ' . $instance['date_closed'] . '</div>';
            }
        }
        ?>
    </span>
    
    </div>
  </div>  
</div>

<div id="admin_access">
  <div class="row clearfix">
    <div class="col-md-12">
      <div id="instructions">
        <p>These are the current individuals who are permitted to manage the <?php echo "$contestTitle";?> Application</p> 
      </div><!-- #instructions -->

      <div id="adminList">
        <span id="currAdmins">
            <?php
            $resADM = $db->query("SELECT * FROM tbl_contestAdmin ORDER BY uniqname");
            while ($row = $resADM->fetch_assoc()) {
                $fullname = ldapGleaner($row['uniqname']);
                echo '<div class="record" id="record-',$row['id'],'">
              <a href="ADMIN/?delete=',$row['id'],'" class="delete"><span style=color:red;font-weight:bold;>X</span></a>
              <strong>',$row['uniqname'],'</strong>  -- ', $fullname[0], "&nbsp;", $fullname[1],
                '</div>';
            }
            ?>
        </span>
      </div><!-- testing delete -->
      <br />
      <div id="myAdminForm"><!-- add Admin -->
        To add an Administrator please enter their <b>uniqname</b> below:<br>
        <input class="form_control" type="text" name="name" /><br>
        <button class="btn btn-info btn-xs" id="adminSub">Add Administrator</button><br /><i>--look up uniqnames using the <a href="https://mcommunity.umich.edu/" target="_blank">Mcommunity directory</a>--</i>      
      </div><!-- add Admin -->

    </div>  
  </div>
</div>

<div id="output">
  <div class="row clearfix">
    <div class="col-md-12">

      <span id="outputData"></span>
    </div>
  </div>
</div>    

    <?php
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
    include("../footer.php");?>
    <!-- //additional script specific to this page -->
      <script src="ADMIN/admJS/admMyScript.js"></script>
</div><!-- End Container of all things -->
</body>
</html>

<?php
  $db->close();
