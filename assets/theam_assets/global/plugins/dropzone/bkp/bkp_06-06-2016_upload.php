<?php
	$uploaddir = '/home/clayton/public_html/uploads/logo/';
	$uploadfile = $uploaddir . basename($_FILES['file']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
		echo "File is valid, and was successfully uploaded.\n";
	} else {
		echo "Possible file upload attack!\n";
	}
?>