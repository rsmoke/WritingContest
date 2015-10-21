<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>LSA-<?php echo "$contestTitle";?> Writing Contests Opens Soon!</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LSA-English Writing Contests">
  <meta name="keywords" content="LSA-English, Hopwood, Writing, UniversityofMichigan">
  <meta name="author" content="LSA-MIS_rsmoke">
  <link rel="icon" href="img/favicon.ico">
  <style>
    html { 
    background: url(img/HopwoodArt.jpg) no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='img/HopwoodArt.jpg', sizingMethod='scale');
    -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='img/HopwoodArt.jpg', sizingMethod='scale')";
  }
  .text-center {
      color: white;
      font-weight: bold;
      text-align: center;
  }
  footer {
      position: fixed;
      bottom: 10px;
      width: 100%;
  }
  a {
    background-color: white;
  }
  </style>
</head>

<body>

  <div>
    <h1 class="text-center">The Hopwood writing contests will be opening again soon.<br>Please
    check back.</h1>
  </div>
<footer>
  <div class="text-center" >
    <address>
      <h3>Department of <?php echo $deptLngName;?></h3>
      <a href="mailto:<?php echo strtolower($addressEmail);?>"><?php echo strtolower($addressEmail);?></a>
      <br><?php echo $addressBldg;?>, <?php echo $address2;?>
      <br><?php echo $addressStreet;?>
      <br>Ann Arbor, MI
      <br><?php echo $addressZip;?>
      <br>P: <?php echo $addressPhone;?>
      <br>F: <?php echo $addressFax;?>
    </address>
      <img class="img" src="img/lsa.png" alt="LSA at the University of Michigan">
  </div>

  <div class="text-center">
    <a href="http://www.regents.umich.edu">© 2014 Regents of the University of Michigan</a>
  </div>
</footer>
</body>
</html>