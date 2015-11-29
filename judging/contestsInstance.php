<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
	
	$whichContests = $_GET['id'];

	$queryContest = "SELECT C1.id, C1.contestsID, C1.date_closed, C1.date_open,C1.notes, L1.name
					 FROM tbl_contest AS C1, lk_contests AS L1
					 WHERE C1.contestsID = $whichContests AND C1.contestsID = L1.id
					 ORDER BY C1.date_open";
		
		$resContest = $db->query($queryContest);
		$result = array();
		
		if ($db->error) {
		    try {    
		        throw new Exception("MySQL error $db->error <br> Query:<br> $queryContest", $db->errno);    
		    } catch(Exception $e ) {
		        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
		        echo nl2br($e->getTraceAsString());
		    }
		}
		while($contests = $resContest->fetch_assoc()){
			array_push($result, array('id' =>$contests["id"],
									  'name' =>$contests["name"],
									  'contestsID' =>$contests["contestsID"], 
									  'date_open'=>$contests["date_open"], 
									  'date_closed'=>$contests["date_closed"], 
									  'notes'=>$contests["notes"]));
		}
		echo (json_encode(array("result" => $result)));

		$resContest->free();
		$db->close();