<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/lib.php';

//Token of the Signing that will be shared.
$signingToken = $argv[1];

// Add as many signers as you need.
$signers = [
    [
        // Unique signer identifier from your system.
        'external_id' => '13579',
        // Role can be signer or viewer.
        'role' => 'signer',
        // Optional parameters.
        'language' => 'en'
    ]
];

$action = 'signing-internal/' . $signingToken . '/signers/add';
$createResponse = request(getApiUrlByAction($action), [
	'signers' => $signers
], REQUEST_POST);

if ($createResponse['status'] != 'ok') {
	print_r($createResponse);
    echo "Signing could not be shared." . PHP_EOL;
    exit;
}
print_r($createResponse);

//Output URL to check signing status.
print("Signing status can be checked here \n");
print(getApiUrlByAction('signing-external/' . $signingToken . '/status')) . PHP_EOL;