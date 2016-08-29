
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

    $sql = "SELECT * FROM vw_entrydetail WHERE uniqname = '$login_name' AND status = 0";
    if(!$result = $db->query($sql)){
        db_fatal_error("Individual submission" , $db->error, $sql, $login_name);
        exit($user_err_message);
    }

    if ($result->num_rows > 0) {
        echo "<table class='table table-responsive table-condensed'>";
        echo "<thead><th>Contest</th><th>Entry Type</th><th>Title</th><th>Submitted</th><th class='btnIcon'>Details</th><th class='btnIcon'>Remove</th></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>";
            echo $row["contestName"] . "</td><td>";
            echo $row["manuscriptType"] . "</td><td>";
            echo $row["title"] . "</td><td>";
            echo date("F jS, Y  g:i A", (strtotime($row["datesubmitted"]))) . "</td>";
            echo "<td class='btnIcon'><button class='btn btn-warning btn-xs covshtbtn' data-entryid='" . $row["EntryId"] . "'><span class='glyphicon glyphicon-file'></span></button></td>";
            echo "<td class='btnIcon'><button class='btn btn-danger btn-xs applicantdeletebtn' data-entryid='" . $row["EntryId"] . "'><span class='glyphicon glyphicon-remove-sign'></span></button></td></tr>";
        }
          echo "</tbody></table>";
    } else {
        echo "You currently have no entries in any of the contests";
    }

    $db->close();
