<?php

/*
 * To change this template use Tools | Templates.
 */

include_once('functions.php');

if($_POST['sent']){
	
	$number = filter_input(INPUT_POST, 'ignore_header', FILTER_VALIDATE_BOOLEAN);
	$truncate = filter_input(INPUT_POST, 'truncate', FILTER_VALIDATE_BOOLEAN);

	

try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        $_FILES['userfile']['error'] ||
        is_array($_FILES['userfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
		
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['userfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['userfile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
	
    if (false === $ext = array_search(
        $finfo->file($_FILES['userfile']['tmp_name']), array(
        'csv' => 'test/csv',
		'csv' => 'text/plain'),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
   $fileName = sprintf('../uploads/%s.%s',
            sha1_file($_FILES['userfile']['tmp_name']),
            $ext
        );
	if (!move_uploaded_file(
        $_FILES['userfile']['tmp_name'],
        sprintf('../uploads/%s.%s',
            sha1_file($_FILES['userfile']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
 chmod($fileName, 0744);
    echo $_FILES[userfile][name].'  uploaded successfully.';
	
	
	
	
	$csv = array_map('str_getcsv', file($fileName));
	//var_dump($csv);
	import($dbh, $csv, $number, $truncate);
	

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
}


?>
<!Doctype>
<html>
	<head>
	
	</head>
	<body>
		
		<form enctype="multipart/form-data" action="import.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" /><br/>
	Ignore Header Lines <input name="ignore_header" type="checkbox" value="true"> 
	Truncate Table <input type="checkbox" name="truncate" value="true"><br/>
			<input type="hidden" name="sent" value="true">
			
    <input type="submit" value="Send File" />
</form>
	</body>
</html>