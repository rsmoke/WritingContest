<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

$admin = $db->real_escape_string(htmlspecialchars($_POST['name']));
$sql = "INSERT INTO tbl_contestadmin (edited_by, uniqname) VALUES('$login_name','$admin')";
$res = $db->query($sql);
if ($db->error) {
    try {
        throw new Exception("MySQL error $db->error <br> Query:<br> $sql", $db->errno);
    } catch (Exception $e) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
} else {
    echo "Successfully Inserted   <b>" .  $admin . "</b>";
}
