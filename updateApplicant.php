<?php
//inserted these values
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

try {
    $applicantid = htmlspecialchars($_POST["id"]);
    $userFname = $db->real_escape_string(htmlspecialchars($_POST["userFname"]));
    $userLname = $db->real_escape_string(htmlspecialchars($_POST["userLname"]));
    $streetL = $db->real_escape_string(htmlspecialchars($_POST["streetL"]));
    $cityL = $db->real_escape_string(htmlspecialchars($_POST["cityL"]));
    $stateL = htmlspecialchars($_POST["stateL"]);
    $zipL = htmlspecialchars($_POST["zipL"]);
    $usrtelL = htmlspecialchars($_POST["usrtelL"]); //allow NULL
    $streetH =  $db->real_escape_string(htmlspecialchars($_POST["streetH"]));
    $cityH =  $db->real_escape_string(htmlspecialchars($_POST["cityH"]));
    $stateH =  htmlspecialchars($_POST["stateH"]);
    $zipH =  htmlspecialchars($_POST["zipH"]);
    $usrtelH =  htmlspecialchars($_POST["usrtelH"]); //allow NULL
    $classLevel =  htmlspecialchars($_POST["classLevel"]);
    $school =  $db->real_escape_string(htmlspecialchars($_POST["school"]));
    $major =  $db->real_escape_string(htmlspecialchars($_POST["major"])); //allow NULL
    $department =  $db->real_escape_string(htmlspecialchars($_POST["department"])); //allow NULL
    $gradYearMonth =  htmlspecialchars($_POST["gradYearMonth"]);
    $degree =  $db->real_escape_string(htmlspecialchars($_POST["degree"]));
    $finAid =  htmlspecialchars($_POST["finAid"]);
    $finAidDesc =  $db->real_escape_string(htmlspecialchars($_POST["finAidDesc"])); //allow NULL
    $namePub =  $db->real_escape_string(htmlspecialchars($_POST["namePub"])); //allow NULL
    $homeNewspaper =  $db->real_escape_string(htmlspecialchars($_POST["homeNewspaper"])); //allow NULL
    $penName =  $db->real_escape_string(htmlspecialchars($_POST["penName"])); //allow NULL

    $sql = <<<SQL
      UPDATE tbl_applicant 
      SET userFname='$userFname',
        userLname='$userLname',
        streetL='$streetL',
        cityL='$cityL',
        stateL='$stateL',
        zipL='$zipL',
        usrtelL='$usrtelL',
        streetH='$streetH',
        cityH='$cityH',
        stateH='$stateH',
        zipH='$zipH',
        usrtelH='$usrtelH',
        classLevel='$classLevel',
        school='$school',
        major='$major',
        department='$department',
        gradYearMonth='$gradYearMonth',
        degree='$degree',
        finAid='$finAid',
        finAidDesc='$finAidDesc',
        namePub='$namePub',
        homeNewspaper='$homeNewspaper',
        penName='$penName',
        edited_by='$login_name'
      WHERE id='$applicantid' AND uniqname = '$login_name'
SQL;

    $result = $db->query($sql);
    //printf("rows inserted: %d\n", $db->affected_rows);
    if ($result) {
      //echo "New record created successfully";
        safeRedirect('index.php');
    } else {
        db_fatal_error($errorMsg, $msg = "ERROR: Update failed", $queryString = $sql);
    }
    $result->close;
    $db->close();

} catch (Exception $e) {
    $result[] = $e->getMessage();
}
exit;
