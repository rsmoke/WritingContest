<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

		$queryAdmin = "SELECT * FROM tbl_contestadmin ORDER BY uniqname ASC";
		
		$resAdmin = $db->query($queryAdmin);
		$resultAdmin = array();
		
		if ($db->error) {
		    try {    
		        throw new Exception("MySQL error $db->error <br> Query:<br> $queryAdmin", $db->errno);    
		    } catch(Exception $e ) {
		        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
		        echo nl2br($e->getTraceAsString());
		    }
		}
		while($admins = $resAdmin->fetch_assoc()){
			$fullName = ldapGleaner($admins["uniqname"]);

			array_push($resultAdmin, array('admin' =>$admins["uniqname"],'adminID' =>$admins["id"], 'adminFname'=>$fullName[0], 'adminLname'=>$fullName[1]));
		}
		echo (json_encode(array("result" => $resultAdmin)));

		$resAdmin->free();
		$db->close();