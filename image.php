<?php

if ($_GET["type"] == "upload") {
	//Check for errors
	if ($_FILES['file_upload']['error'] > 0) {
	    die('An error ocurred when uploading.');
	}
	if (!getimagesize($_FILES['file_upload']['tmp_name'])) {
	    die('Please ensure you are uploading an image.');
	}

	//Check filetype
	$upload_type = strtolower($_FILES['file_upload']['type']);
	if (($upload_type != 'image/png') && ($upload_type != 'image/jpg') && ($upload_type != 'image/jpeg') && ($upload_type != 'image/gif')) {
	    die('Unsupported filetype uploaded: ' . $upload_type);
	}

	//Check filesize
	if ($_FILES['file_upload']['size'] > 10000000) {
	    die('File uploaded exceeds maximum upload size.');
	}

	//Check if the file exists
	if (file_exists($_GET['path'] . '/image')) {
	    die('File with that name already exists.');
	}

	//Upload file
	if (!move_uploaded_file($_FILES['file_upload']['tmp_name'], $_GET['path'] . '/image')) {
	    die('Error uploading file - check destination is writeable.');
	}

	//Redirect back
	header("Location: " . str_replace("@J@a@k@e@", "&", $_GET["redirect"]));
}
elseif ($_GET["type"] == "delete") {
	$file = $_GET["path"] . "/image";
	if (!unlink($file)) {
		die("Error deleting $file");
	}
	else {
		header("Location: " . str_replace("@J@a@k@e@", "&", $_GET["redirect"]));
	}
}

?>
