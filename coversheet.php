<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
$entryid = $db->real_escape_string(htmlspecialchars($_GET["sbmid"]));

try {
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
        db_fatal_error($db->error, "data select issue", $sqlSelect);
        exit;
    }
  //do stuff with your $result set

    if ($result->num_rows > 0) {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
          <META http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <title>Hopwood Writing Contests</title>
        </head>

        <body>";

        echo "<div style='font-size:.8rem;'>Instructions <br>";
        echo "<ol>";
        echo "<li>Follow the instructions related to your specific contest for preparing your submission. See instructions <a href='http://www.lsa.umich.edu/hopwood/contestsprizes' target='_blank'>here</a></li>";
        echo "<li>Print this page using your browsers print button.</li>";
        echo "<li>Attach printed Coversheet to your entry.</li>";
        echo "<li>Use the browser back button to return to your list of entries</li>";
        echo "</ol></div>";
        echo "<h1>============================================================</h1>";
        echo "<h1>Coverpage/Titlesheet</h1>";
        while ($row = $result->fetch_assoc()) {
            echo "<div style='padding: 0 0 0 40px;'>";
            echo "<div><strong>Entry Title:</strong><h2> " . $row["title"] . "</h2></div>";

            echo "<div>Authors Name: " . $row["penName"] ."</div>";

            echo "<div>The contest and division entered: " . $row["contestName"] . " - " . $row["manuscriptType"] . "</div>";

            echo "<div>Date Submitted Online: " . $row["datesubmitted"] . "</div>";

            echo "<div style='font-size:.8rem;'>Details : ". $_SERVER["REQUEST_TIME"] . "<=>" . $row["EntryId"] . "</div>";
            echo "</div>";

        }
           echo "<h1>============================================================</h1>";
           echo "</body></html>";
    } else {
        echo "Nothing to show!";
    }
     $db->close();
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
