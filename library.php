<?php
$books = array ();
require __DIR__ . '/books.inc.php';

if (! isset ( $_GET ['author'] )) {
	$response = array (
			'status' => 'error',
			'message' => 'no author specified' 
	);
} else {
	if (isset ( $books [$_GET ['author']] )) {
		$response = array (
				'status' => 'ok',
				'response' => $books [$_GET ['author']] 
		);
	} else {
		$response = array (
				'status' => 'error',
				'message' => 'author not found' 
		);
	}
}

header ( 'Content-Type:application/json' );
echo json_encode ( $response );
