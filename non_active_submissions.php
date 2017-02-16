
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

    $sql = "SELECT contestName, manuscriptType, document, title, datesubmitted, EntryId, status FROM vw_entrydetail WHERE uniqname = '$login_name' AND status NOT IN (0,1)";
    if ($result = $db->prepare($sql)) {
        $result->execute();
        $result->bind_result($contestName, $manuscriptType, $document, $title,  $datesubmitted,  $EntryId, $status);
        $result->store_result();

        echo "<table class='table table-responsive table-condensed table-hover'>";
        echo "<thead><th>Contest</th><th>Entry Type</th><th>Title</th><th>Submitted</th><th class='btnIcon'>Manuscript<br><span style='font-size:.9rem;'>opens in a new browser tab</span></th><th>Entry Status</th></thead><tbody>";
        for ($i = 0; $i < $result->num_rows; $i++) {
          $result->data_seek($i);
          $result->fetch();
          switch($status) {
            case 1:
                $status_notice = "<span class='label label-danger'>Deleted</span>";
                break;
            case 2:
                $status_notice = "<span class='label label-info'>Archived</span>";
                break;
            case 3:
                $status_notice = "<span class='label label-warning'>Disqualified</span>";
                break;
            default:
                $status_notice = $status;
          }

            echo "<tr><td>";
            echo "$contestName</td><td>";
            echo "$manuscriptType</td><td>";
            echo "$title</td><td>";
            echo date("F jS, Y  g:i A", (strtotime($datesubmitted))) . "</td>";
            echo "<td class='btnIcon'><a href='fileholder.php?file=$document' target='_blank'><span class='glyphicon glyphicon-book'></span></a></td>";
            echo "<td>" . $status_notice  . "</td></tr>";
        }
          echo "</tbody></table>";
    } else {
        echo "You currently have no entries in any of the contests";
    }
