# Universal API PHP Example

Universal API is a versatile tool that enables signing documents internally, within your system, and collecting signatures from 3rd parties outside your system, using a wide variety of eID tools ([eIDs supported in the Dokobit portal by countries](https://support.dokobit.com/article/709-supported-countries-eids)).

Signing takes place in the account-less Dokobit signing interface. With your organization’s branding setup, the transition from your system to the signing page is made seamless and straightforward. Document signing invitations to 3rd parties also adapt to the styling you set.

A wide selection of optional parameters and supplementary API methods allow you to build a reliable document signing solution tailored to your needs.

Check complete documentation [here](https://beta.dokobit.com/api/doc/universal).
Request developer access token [here](https://www.dokobit.com/developers/request-token).

## Example configuration
- Set `$accessToken` variable in [`config.php`](https://github.com/dokobit/universal-api-php-example/blob/main/config/config.php).

## Flow

### Create signing
Universal API offers two options how your document can be shared with participants. 
[`create_signing-external.php`](https://github.com/dokobit/universal-api-php-example/blob/main/create_signing-external.php) sends e-mail invitation to sign document in Dokobit signing interface.
[`create_signing-internal.php`](https://github.com/dokobit/universal-api-php-example/blob/main/create_signing-internal.php) generated a Dokobit signing interface URL for you to redirect user to.
- Examples will upload a file Resources/test.pdf to the Universal API and create a signing.
- Multiple signers could be added.
- Notification to sign a document would be sent to the signer's `email`, if specified.
- If a `comment` is provided, users would get this message displayed in the notification email.
- Response would also return a link to check the signing status.
- Full list of available attributes can be found [here](https://beta.dokobit.com/api/doc/universal).
- External signers can be added to internal signing.

### Sign
Once signing is created, users will be able to sign the document. You can use [test data](https://support.dokobit.com/article/667-mobile-id-and-smart-id-test-data) for signing.

### Retrieving signed document
Document signing postback calls are triggered, if `postback_url` was set while creating a signing.
There are eight types of postback calls:
1. `signing_created` - Document signing created;
2. `signer_declined` - Document signer has declined to sign the document;
3. `signer_signed` - Document signed by one of the signers;
4. `document_received` - Document delivery was confirmed by the receiver;
5. `signing_completed` - Document signed by all parties;
More details can be found [here](https://support.dokobit.com/article/820-dokobit-webhooks).

[`postback-handler.php`](https://github.com/dokobit/universal-api-php-example/blob/main/public/postback-handler.php) - PHP code example for handling postback calls. The file should be placed in the public web directory, accessible for Universal API.

To retrieve the signed document using these examples, you will need:
- Put [`postback-handler.php`](https://github.com/dokobit/universal-api-php-example/blob/main/public/postback-handler.php) in a public web directory, accessible for Universal API.
- Set `$postbackUrl` parameter in [`config.php`](https://github.com/dokobit/universal-api-php-example/blob/main/config/config.php) with URL where the [`postback-handler.php`](https://github.com/dokobit/universal-api-php-example/blob/main/public/postback-handler.php) will be available. For, e.g. `http://your-public-host/postback-handler.php`.
- Create signing.
- Sign.
- Information about a signed document will be sent to the postback URL. `postback-handler.php` will handle postback, and the signed file will be stored in the dedicated directory.
- Log file `postback.log` containing postback information, will be placed in the dedicated directory.

## Helpful methods

[`add_signer-external.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/add_signer-external.php) and [`add_signer-internal.php.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/add_signer-internal.php) - Adds participants to an existing signing.

[`remove_signer-external.php <signing_token> <signer_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/remove_signer-external.php) and [`remove_signer-internal.php <signing_token> <signer_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/remove_signer-internal.php) - Removes the participant from an existing signing, only if a person has not signed the document yet.

[`remind-external.php <signing_token> <signer_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/remind-external.php) - Sends a reminder to external participant.

[`update_signing-external.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/update_signing-external.php) and [`update_signing-internal.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/update_signing-internal.php) - Updates specific signing parameters.

[`delete_signing-external.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/delete_signing-external.php) and [`delete_signing-internal.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/delete_signing-internal.php) - Deletes a specific signing. Document deletion is permanent and cannot be undone. The document will be removed from your account and it will no longer be accessible to signing participants that have not signed the document yet.

[`signing_status-external.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/signing_status-external.php) and [`signing_status-internal.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/signing_status-internal.php) - Retrieves status and information about a specific signing.

[`download_signing-external.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/download_signing-external.php) and [`download_signing-internal.php <signing_token>`](https://github.com/dokobit/universal-api-php-example/blob/main/download_signing-internal.php) - Downloads and saves the signed file.
