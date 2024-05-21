<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/lib.php';

$fileLocation = __DIR__ . '/Resources/test.pdf';

/**
 * File details
 */

// Multiple files can be uploaded.
$files = [
    [
        'name' => basename($fileLocation),
        'digest' => hash_file('sha256', $fileLocation),
        'content'=> base64_encode(file_get_contents($fileLocation))
    ]
];

/**
* Signer details
*/

//Add as many signers as you need.
$signers = [
    [
        // Unique signer identifier from your system.
        'external_id' => '12345',
        'name' => 'First',
        'surname' => 'Signer',
        // Signer's email for sending signing invitation email. Required if phone is not set.
        'email' => 'test+1@dokobit.com',
        // Role can be set to signer or viewer.
        'role' => 'signer',
        // Other optional parameters
        'position' => 'Administrator',
        'notifications_language' => 'en'
    ],
    [
        // Unique signer identifier from your system.
        'external_id' => '67890',
        'name' => 'Second',
        'surname' => 'Signer',
        // Signer's email for sending signing invitation email. Required if phone is not set.
        'email' => 'test+2@dokobit.com',
        // Personal code. This will enable an additional authentication step before signing.
        'code' => '30303039903',
        'country_code' => 'lt',
        // Role can be set to signer or viewer.
        'role' => 'signer',
        // Other optional parameters.
        'position' => 'Director',
        'notifications_language' => 'en'
    ]
];

/**
 * Create signing
 */

$action = 'signing-external/create';
$createResponse = request(getApiUrlByAction($action), [
    //Signed document format. Check documentation for all available options.
    'type' => "pdf",
    'name' => "Agreement",
    'signers' => $signers,
    'files' => $files,
    'postback_url' => $postback_url,
    'deadline' => date("Y-m-d\TH:i:s\Z", strtotime('+7 days')),
    // Signing deadline date with specified timezone fragment.
    'comment' => 'Please sign at your earliest convenience',
    'require_qualified_signatures' => true,
    // If set to true the document will be flattened so that the form fields become part of the document content and cannot be edited after signing. Only applicable for PDF type signing.
    'flatten_pdf' => true
], REQUEST_POST);

if ($createResponse['status'] != 'ok') {
	print_r($createResponse);
    echo "Signing could not be created." . PHP_EOL;
    exit;
}
print_r($createResponse);

//Output URL to check signing status.
print("Signing status can be checked here \n");
print(getApiUrlByAction('signing-external/' . $createResponse['token'] . '/status')) . PHP_EOL;
