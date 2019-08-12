
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

    $sql = "SELECT contestName, manuscriptType, document, title, datesubmitted, EntryId, date_closed FROM vw_entrydetail WHERE uniqname = '$login_name' AND status = 0";

    if (!$result = $db->query($sql)) {
            db_fatal_error("data select issue", $db->error, $sql, $login_name);
            exit(user_err_message);
        } else {
            if ($result->num_rows > 0 ){
                echo "<table class='table table-responsive table-condensed'>";
                echo "<thead><th>Contest</th><th>Entry Type</th><th>Title</th><th>Submitted</th><th class='btnIcon'>Manuscript<br><span style='font-size:.9rem;'>opens in a new browser tab</span></th><th class='btnIcon'>Remove<br><span style='font-size:.9rem;'>available until contest closes</span></th></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>";
                    echo $row['contestName'] . "</td><td>";
                    echo $row['manuscriptType'] . "</td><td>";
                    echo $row['title'] . "</td><td>";
                    echo date("F jS, Y  g:i A", (strtotime($row['datesubmitted']))) . "</td>";
                    echo "<td class='btnIcon'><a href='fileholder.php?file=" . $row['document'] . "' target='_blank'><span class='glyphicon glyphicon-book'></span></a></td>";
                    echo "<td class='btnIcon'><button class='btn btn-danger btn-xs ";

                    echo date("Y-m-d H:i:s") > $row['date_closed']? ' disabled ' : '';

                    echo " applicantdeletebtn' data-entryid='" . $row['EntryId'] . "'><span class='glyphicon glyphicon-remove-sign'></span></button></td></tr>";
                }
                  echo "</tbody></table>";
            } else {
                echo "You currently have no entries in any of the contests";
            }
        }