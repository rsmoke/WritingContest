<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

$contestsID = $db->real_escape_string(htmlspecialchars($_POST['contestID']));
$contestNotes = $db->real_escape_string(htmlspecialchars($_POST['notes']));
$contestOpen = $db->real_escape_string(htmlspecialchars($_POST['openDate']));
$contestClose = $db->real_escape_string(htmlspecialchars($_POST['closeDate']));

$sql = "INSERT INTO tbl_contest
(`contestsID`,
`date_open`,
`date_closed`,
`notes`,
`created_by`)
VALUES
('$contestsID',
'$contestOpen',
'$contestClose',
'$contestNotes',
'$login_name')";

$res = $db->query($sql);
if ($db->error) {
    try {
        throw new Exception("MySQL error $db->error <br> Query:<br> $sql", $db->errno);
    } catch (Exception $e) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
} else {
    header("Location: index.php");
}
