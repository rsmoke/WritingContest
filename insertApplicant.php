<?php
//inserted these values
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

  $userFname = $db->real_escape_string(htmlspecialchars($_POST["userFname"]));
  $userLname = $db->real_escape_string(htmlspecialchars($_POST["userLname"]));
  $umid = htmlspecialchars($_POST["umid"]);
  $uniqname = htmlspecialchars($_POST["uniqname"]);
  $streetL = $db->real_escape_string(htmlspecialchars($_POST["streetL"]));
  $cityL = $db->real_escape_string(htmlspecialchars($_POST["cityL"]));
  $stateL = htmlspecialchars($_POST["stateL"]);
  $zipL = htmlspecialchars($_POST["zipL"]);
  $usrtelL = htmlspecialchars($_POST["usrtelL"]); //allow NULL
  $streetH =  $db->real_escape_string(htmlspecialchars($_POST["streetH"]));
  $cityH =  $db->real_escape_string(htmlspecialchars($_POST["cityH"]));
  $stateH =  htmlspecialchars($_POST["stateH"]);
  $countryH =  htmlspecialchars($_POST["countryH"]);
  $zipH =  htmlspecialchars($_POST["zipH"]);
  $usrtelH =  htmlspecialchars($_POST["usrtelH"]); //allow NULL
  $classLevel =  htmlspecialchars($_POST["classLevel"]);
  $school =  $db->real_escape_string(htmlspecialchars($_POST["school"]));
  $campusLocation =  htmlspecialchars($_POST["campusLocation"]);
  $major =  $db->real_escape_string(htmlspecialchars($_POST["major"])); //allow NULL
  $department =  $db->real_escape_string(htmlspecialchars($_POST["department"])); //allow NULL
  $gradYearMonth =  htmlspecialchars($_POST["gradYearMonth"]);
  $degree =  $db->real_escape_string(htmlspecialchars($_POST["degree"]));
  $finAid =  htmlspecialchars($_POST["finAid"]);
  $finAidNotice = htmlspecialchars($_POST["finAidNotice"]);
  $finAidDesc =  $db->real_escape_string(htmlspecialchars($_POST["finAidDesc"])); //allow NULL
  $namePub =  $db->real_escape_string(htmlspecialchars($_POST["namePub"])); //allow NULL
  $homeNewspaper =  $db->real_escape_string(htmlspecialchars($_POST["homeNewspaper"])); //allow NULL
  $penName =  $db->real_escape_string(htmlspecialchars($_POST["penName"])); //allow NULL

  $sqlInsert = <<<SQL
  INSERT INTO `tbl_applicant` (`userFname`, `userLname`, `umid`, `uniqname`, `streetL`, `cityL`, `stateL`
    , `zipL`, `usrtelL`, `streetH`, `cityH`, `stateH`, `countryH`, `zipH`, `usrtelH`, `classLevel`, `school`, `campusLocation`, `major`
    , `department`, `gradYearMonth`, `degree`, `finAid`, `finAidNotice`, `finAidDesc`, `namePub`, `homeNewspaper`, `penName`
    , `created_by`, `created_on`)
  VALUES ('$userFname', '$userLname', '$umid', '$uniqname', '$streetL','$cityL', '$stateL'
    , '$zipL', '$usrtelL', '$streetH','$cityH', '$stateH', '$countryH', '$zipH', '$usrtelH', '$classLevel', '$school'
    , '$campusLocation', '$major', '$department', '$gradYearMonth', '$degree', '$finAid', '$finAidNotice', '$finAidDesc', '$namePub'
    , '$homeNewspaper', '$penName', '$login_name', now())
SQL;
if (!$db->query($sqlInsert)) {
   db_fatal_error("Insert failed", $db_error, $sqlInsert, $login_name);
        exit($user_err_message);
}
  //echo "New record created successfully";
  safeRedirect('index.php');
  exit();

