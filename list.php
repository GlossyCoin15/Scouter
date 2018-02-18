<?php

function delete_files($target) {
	if (is_dir($target)) {
		$files = glob($target . '*', GLOB_MARK);
		foreach ($files as $file) {
			delete_files($file);      
		}
		rmdir($target);
	}
	elseif (is_file($target)) {
		unlink($target);  
	}
}

if ($_GET["type"] == "delete") {
	$folder = $_GET["path"];
	$data = file($folder . "../../data.txt"); 
	$out = array(); 
	foreach($data as $line) { 
		if(trim($line) != $_GET["string"]) { 
			$out[] = $line; 
		} 
	} 
	$fp = fopen($folder . "../../data.txt", "w+"); 
	flock($fp, LOCK_EX); 
	foreach($out as $line) { 
		fwrite($fp, $line . ""); 
	} 
	flock($fp, LOCK_UN); 
	fclose($fp);

	delete_files($folder);

	header("Location: " . str_replace("@J@a@k@e@", "&", $_GET["redirect"]));
}
elseif ($_GET["type"] == "add") {
	$data = fopen($_GET["path"] . "../data.txt", "a") or die("Unable to open file!");
	fwrite($data, $_POST["name"] . "\n");
	fclose($data);
	header("Location: " . str_replace("@J@a@k@e@", "&", $_GET["redirect"]));
}

?>
