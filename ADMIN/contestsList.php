<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

	$queryContests = "SELECT L1.id, L1.name
					 FROM lk_contests AS L1
					 ORDER BY L1.Name ASC";
		
		$resContests = $db->query($queryContests);
		$result = array();
		
		if ($db->error) {
		    try {    
		        throw new Exception("MySQL error $db->error <br> Query:<br> $queryContests", $db->errno);    
		    } catch(Exception $e ) {
		        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
		        echo nl2br($e->getTraceAsString());
		    }
		}
		while($contests = $resContests->fetch_assoc()){
			array_push($result, array('contestsID' =>$contests["id"],
									  'name' =>$contests["name"]));
		}
		echo (json_encode(array("result" => $result)));

		$resContests->free();
		$db->close();