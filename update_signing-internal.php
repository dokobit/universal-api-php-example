<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/lib.php';

//Token of the Signing that will be updated.
$signingToken = $argv[1];

$action = 'signing-internal/' . $signingToken . '/update';
$createResponse = request(getApiUrlByAction($action), [
    // Add parameters to be updated. Check documentation for all available options.
	'require_qualified_signatures' => false
], REQUEST_POST);

if ($createResponse['status'] != 'ok') {
	print_r($createResponse);
    echo "Signing could not be updated." . PHP_EOL;
    exit;
}
print_r($createResponse);
