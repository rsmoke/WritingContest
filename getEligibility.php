<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

$contestID = htmlspecialchars($_GET["id"]);

$sql = "SELECT eligibilityRules FROM lk_contests WHERE id='$contestID'";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "Rules: " . $row["eligibilityRules"];
    }
} else {
    echo "0 results";
}

