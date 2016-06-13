
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
$entryid = $db->real_escape_string(htmlspecialchars($_POST['sbmid']));

$sqlUpdate = <<<SQL
    UPDATE tbl_entry
    SET status = 1, edited_by = '$login_name'
    WHERE id = $entryid
SQL;
    if(!$result = $db->query($sqlUpdate)){
        db_fatal_error("Update failed", $db->error, $sqlUpdate, $login_name);
        exit($user_err_message);
    }

    $db->close();
