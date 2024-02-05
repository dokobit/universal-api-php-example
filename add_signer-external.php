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
        'name' => 'Test',
        'surname' => 'Signer',
        // Signer's email for sending signing invitation email. Required if phone is not set.
        'email' => 'test+share@dokobit.com',
        // Role can be signer or viewer.
        'role' => 'signer',
        // Optional parameters.
        'company' => 'Example Company',
        'position' => 'Employee'
    ]
];

$action = 'signing-external/' . $signingToken . '/signers/add';
$createResponse = request(getApiUrlByAction($action), [
	'signers' => $signers,
	'comment' => "This is a message that signer will get"
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