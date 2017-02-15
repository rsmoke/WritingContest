
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

    $sql = "SELECT contestName, manuscriptType, document, title, datesubmitted, EntryId, date_closed FROM vw_entrydetail WHERE uniqname = '$login_name' AND status = 0";
    if ($result = $db->prepare($sql)) {
        $result->execute();
        $result->bind_result($contestName, $manuscriptType, $document, $title,  $datesubmitted,  $EntryId, $date_closed);
        $result->store_result();

        echo "<table class='table table-responsive table-condensed'>";
        echo "<thead><th>Contest</th><th>Entry Type</th><th>Title</th><th>Submitted</th><th class='btnIcon'>Manuscript<br><span style='font-size:.9rem;'>opens in a new browser tab</span></th><th class='btnIcon'>Remove<br><span style='font-size:.9rem;'>available until contest closes</span></th></thead><tbody>";
        for ($i = 0; $i < $result->num_rows; $i++) {
          $result->data_seek($i);
          $result->fetch();
            echo "<tr><td>";
            echo "$contestName</td><td>";
            echo "$manuscriptType</td><td>";
            echo "$title</td><td>";
            echo date("F jS, Y  g:i A", (strtotime($datesubmitted))) . "</td>";
            echo "<td class='btnIcon'><a href='fileholder.php?file=$document' target='_blank'><span class='glyphicon glyphicon-book'></span></a></td>";
            echo "<td class='btnIcon'><button class='btn btn-danger btn-xs ";

            echo date("Y-m-d H:i:s") > $date_closed? ' disabled ' : '';

            echo " applicantdeletebtn' data-entryid='$EntryId'><span class='glyphicon glyphicon-remove-sign'></span></button></td></tr>";
        }
          echo "</tbody></table>";
    } else {
        echo "You currently have no entries in any of the contests";
    }

    $db->close();
