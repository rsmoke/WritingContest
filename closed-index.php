<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');

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

  <link rel="stylesheet" href="css/bootstrap.min.css"><!-- 3.3.1 -->
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/default.css" media="all">
</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><?php echo "$contestTitle";?></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    </div>
  </div>
  </nav>

  <div class="container"><!--Container of all things -->
  <div>
    <img src="img/HopwoodArt.jpg" alt="HopwoodArt" class="center-block img-responsive">
  </div>
    <h4 class="text-center">The Hopwood writing contests will be opening soon.<br>Please
    check back.</h4>
  </div>

<?php
    include("footer.php");?>

</body>
</html>