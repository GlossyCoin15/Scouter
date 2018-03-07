<?php

function getBetweenStrings($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

function getDataLine($tag_name, $file_name) {
	$lines = file($file_name);
	foreach ($lines as $lineNumber => $line) {
		if (strpos($line, $tag_name . "<@J@a@k@e@>") !== false) {
			break;
		}
	}
	return $line;
}

function getData($tag_name, $file_name) {
	return getBetweenStrings(getDataLine($tag_name, $file_name), "<@J@a@k@e@>", "<@P@e@v@e@r@l@y@>");
}

function addData($data_line, $file_string, $search_string) {
	$folder = $_GET["path"];
	$data = file($folder . $file_string); 
	$out = array(); 
	foreach($data as $line) { 
		if($line == getDataLine($search_string, $_GET["path"] . $file_string)) { 
			$out[] = $data_line; 
		}
		else {
			$out[] = $line;
		}
	} 
	$fp = fopen($folder . $file_string, "w+"); 
	flock($fp, LOCK_EX); 
	foreach($out as $line) { 
		fwrite($fp, $line . ""); 
	} 
	flock($fp, LOCK_UN); 
	fclose($fp);
}

if ($_GET["type"] == "delete_match") {
	$matches = explode("<@Z@>", getData("Matches", $_GET["path"] . "../data.txt"));
	if (($key = array_search($_GET["match"], $matches)) !== false) {
		unset($matches[$key]);
	}
	addData("Matches<@J@a@k@e@>" . implode("<@Z@>", $matches) . "<@P@e@v@e@r@l@y@>\n", "../data.txt", "Matches");

	header("Location: " . str_replace("@J@a@k@e@", "&", $_GET["redirect"]));
}
elseif ($_GET["type"] == "add_match") {
	$match_data = getData("Matches", $_GET["path"] . "data.txt");
	$matches = explode("<@Z@>", $match_data);
	if (!empty($match_data)) {
		$matches[] = $_POST["number"];
		$data_string = implode("<@Z@>", $matches);
	}
	else {
		$data_string = $_POST["number"];
	}
	addData("Matches<@J@a@k@e@>" . $data_string . "<@P@e@v@e@r@l@y@>\n", "data.txt", "Matches");
	
	header("Location: " . str_replace("@J@a@k@e@", "&", $_GET["redirect"]));
}
elseif ($_GET["type"] == "update") {
	$data_array = array();
	foreach ($_POST as $key => $value) {
		$value = preg_replace("/\r/", "", $value);
		$value = preg_replace("/\n/", "<:BR:>", $value);
		if (strpos($key, '::') !== false) {
			$box_number = explode("::", $key)[0];
			$box_type = explode("::", $key)[1];
			if (!array_key_exists($box_type, $data_array)) {
				$data_array[$box_type] = array();
			}
			$data_array[$box_type][] = "<" . $box_number . "::" . $value . ">";
		}
		else {
			$data_array[$key][] = $value;
		}
	}
	foreach ($data_array as $array_key => $data_array_array) {
		addData(str_replace("_", " ", $array_key) . "<@J@a@k@e@>" . implode("<@Z@>", $data_array_array) . "<@P@e@v@e@r@l@y@>\n", "data.txt", str_replace("_", " ", $array_key));
	}
	
	header("Location: " . str_replace("@J@a@k@e@", "&", $_GET["redirect"]));
}

?>
