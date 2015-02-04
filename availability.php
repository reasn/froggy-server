<?php
header("Access-Control-Allow-Origin: *");

$books = array ();
require __DIR__ . '/books.inc.php';

$request = json_decode ( file_get_contents ( 'php://input' ), true );

usleep ( 1000 * rand ( 500, 2000 ) );

if (rand ( 0, 1 ) === 1) {
	header ( $_SERVER ['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500 );
	echo <<<EOT
<html>
	<head>
		<title>Error</title>
	</head>
	<body>
			<h1>Internal Server Error</h1>
		<p>The chiplets and tubes of this server have been attacked by a pack of raving pink rabbits. Beware!</p>
		<p>You may try again later. Or now. Just try!</p>
	</body>
</html>
EOT;
	exit ();
}

if (! isset ( $request ['author'] )) {
	$response = array (
			'status' => 'error',
			'message' => 'no author specified' 
	);
} else if (! isset ( $request ['title'] )) {
	$response = array (
			'status' => 'error',
			'message' => 'no title specified' 
	);
} else {
	$candidate = null;
	foreach ( $books as $authorsBooks) {
		foreach ($authorsBooks as $candidate) {
			if ($candidate ['author'] === $request ['author'] && $candidate ['title'] === $request ['title'])
				$book = $candidate;
		}
	}
	if ($candidate === null) {
		$response = array (
				'status' => 'error',
				'message' => 'no title specified' 
		);
	} else {
		$response = array (
				'status' => 'ok',
				'response' => array (
						'price' => rand ( 20, 100 ),
						'availability' => rand ( 0, 1 ) === 1 ? 'IN_STOCK' : 'OUT' 
				) 
		);
	}
}

header ( 'Content-Type:application/json' );
echo json_encode ( $response );
