<?php
    //$uploaddir = '/home/clayton/public_html/uploads/logo/';	
    $upload_path = '/home/clayton/public_html/uploads/agencies';
    $new_name = $_FILES['file']['name'];
    //$uploadfile = $uploaddir . basename($_FILES['file']['name']);    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.'/'.$new_name)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
    }