<?php

$title = trim( 
	isset( $_REQUEST['title']) ? $_REQUEST['title'] : 'main',
	"\0..\x1F /");
$edit = isset($_REQUEST['edit']);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Check submitted data
	$errors = array();
	if (! strlen( $title))
		$errors[] = "Fill the Title!";
	if (strlen( $_REQUEST['content']) == 0 && empty( $_FILES['file']['size']))
		$errors[] = "Fill Content or upload a file!";
	$content = stripslashes( $_REQUEST['content']);
	if (! $errors) {
		// Save submitted block
		umask(0);
		$target_filename = $title;
		@mkdir( dirname( $target_filename), 0777, true);
		if ($_FILES['file']['size']) {
			// Use submitted file
			move_uploaded_file( $_FILES['file']['tmp_name'], $target_filename);
		} else {
			// Use submitted text
			file_put_contents( $target_filename, $content);
		}
		header( 'Location: /'.str_replace( '%2F', '/', urlencode( $title)));
		exit();
	} else {
		// Continue editing
		$edit = 1;
	}
}


// Enum all blocks
foreach (array( 'header', $title, 'footer') as $i => $block) {
	$filename = $block;
	$is_required = ($i == 1);
	if ($is_required && ($edit || !is_file( $filename))) {
		// Edit this block
		$content = null;
		$is_text = $is_image = false;
		if (is_file( $filename)) {
			$content = file_get_contents( $filename);
			$is_text = strlen( $content) ? (boolean) mb_detect_encoding( $content) : false;
			$is_image = (boolean) getimagesize( $filename);
		}
		include 'editform.php';
	} elseif (is_file( $filename)) {
		// Display existing block
		assert( !preg_match( '/\.(jpe?g|gif|png|css|js|html?)$/', $block));
		include $filename;
	}
}

