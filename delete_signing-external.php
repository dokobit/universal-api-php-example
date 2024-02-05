<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/lib.php';

//Token of the signing.
$signingToken = $argv[1];

/**
* Delete signing from your account. Document will no longer be accessible to signing participants that have not signed the document yet.
*/
$action = 'signing-external/' . $signingToken . '/delete';
$createResponse = request(getApiUrlByAction($action), [], REQUEST_POST);

print_r($createResponse);