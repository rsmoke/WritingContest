<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$idSent =  htmlspecialchars($_POST['delid']);

if ($_SESSION['isAdmin']) {
    if ($idSent != 1) {
        $sqlDelete = <<< _SQL
            DELETE FROM tbl_contestadmin
            WHERE id = $idSent;
_SQL;

        if (!$result= $db->query($sqlDelete)) {
            db_fatal_error($db->error, $siteTitle, "data delete issue", $sqlDelete);
            exit;
        }

        echo "Deleted admin ID: " . $idSent;
    } else {
         echo "nothin doin";
    }
} else {
        echo "unauthorized";
}