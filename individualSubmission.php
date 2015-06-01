
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

try {
    $sql = "SELECT * FROM vw_entrydetail WHERE uniqname = '$login_name'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table table-responsive table-condensed'>";
        echo "<thead><th>Contest</th><th>Entry Type</th><th>Title</th><th>Coversheet</th></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>";
            echo $row["contestName"] . "</td><td>";
            echo $row["manuscriptType"] . "</td><td>";
            echo $row["title"] . "</td><td>";
            echo "<button class='btn btn-warning btn-xs covshtbtn' data-entryid='" . $row["EntryId"] . "'><span class='glyphicon glyphicon-file'></span></button></td></tr>";
        }
          echo "</tbody></table>";
    } else {
        echo "0 entries";
    }

    $db->close();
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
