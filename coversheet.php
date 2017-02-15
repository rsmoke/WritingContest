<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
$entryid = $db->real_escape_string(htmlspecialchars($_GET["sbmid"]));

$sqlSelect = <<<SQL
    SELECT EntryId,
        title,
        uniqname,
        firstname,
        lastname,
        penName,
        manuscriptType,
        contestName,
        datesubmitted
    FROM vw_entrydetail
    WHERE uniqname = '$login_name' AND EntryId = $entryid

SQL;
    if (!$result = $db->query($sqlSelect)) {
        db_fatal_error("Data select issue", $db->error, $sqlSelect, $login_name);
        exit($user_err_message);
    }
  //do stuff with your $result set

    if ($result->num_rows > 0) {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
          <META http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <title>Hopwood Writing Contests</title>
          <link rel='icon' href='img/favicon.ico'>
        </head>

        <body>";

        echo "<div><h1>Entry Submission Details</h1>";
        echo "<ul>";
        echo "<li>Contest rules can be found <a href='http://www.lsa.umich.edu/hopwood/contests-prizes' target='_blank'>here</a></li>";
        echo "<li>Use the browser back button to return to your list of entries</li>";
        echo "</ul></div>";
        echo "<h1>============================================================</h1>";
        while ($row = $result->fetch_assoc()) {
            echo "<div style='padding: 0 0 0 40px;'>";
            echo "<h2>Entry Title:</strong> " . $row["title"] . "</h2>";

            echo "<strong>Author's Pen name:</strong> " . $row["penName"] ."<br />";

            echo "<strong>Contest and division entered:</strong> " . $row["contestName"] . " - " . $row["manuscriptType"] . "<br />";

            echo "<strong>Date submitted:</strong> " . date("F jS, Y - g:i:s A", (strtotime($row["datesubmitted"])));

            echo "</div>";

        }
           echo "<h1>============================================================</h1>";
           echo "</body></html>";
    } else {
        echo "Nothing to show!";
    }

