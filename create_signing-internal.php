<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/lib.php';

$fileLocation = __DIR__ . '/Resources/test.pdf';

/**
 * File details
 */

//For 'pdf' type - only one file is supported.
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
        // Role can be set to signer or viewer.
        'role' => 'signer',
        // Other optional parameters.
        'language' => 'en'
    ],
    [
        // Unique signer identifier from your system.
        'external_id' => '67890',
        // Role can be set to signer or viewer.
        'role' => 'signer',
        // Other optional parameters.
        'language' => 'lt'
    ]
];

/**
 * Create signing
 */

$action = 'signing-internal/create';
$createResponse = request(getApiUrlByAction($action), [
    //Signed document format. Check documentation for all available options.
    'type' => "pdf",
    'name' => "Agreement",
    'signers' => $signers,
    'files' => $files,
    'postback_url' => $postback_url,
    'redirect_uri' => 'http://example.com?postback',
    // Redirect URI that will be used for redirecting signer after signing is completed.
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
print(getApiUrlByAction('signing-internal/' . $createResponse['token'] . '/status')) . PHP_EOL;