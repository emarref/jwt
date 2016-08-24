An implementation of the [JSON Web Token (JWT)](https://tools.ietf.org/html/draft-ietf-oauth-json-web-token-30) draft in PHP. See [jwt.io](http://jwt.io/) for more information on JWT.

[![Build Status](https://travis-ci.org/emarref/jwt.svg?branch=master)](https://travis-ci.org/emarref/jwt) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/emarref/jwt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/emarref/jwt/?branch=master)

Features include:

- Token serialization
- Token deserialization
- Token verification
    - `aud`, `exp`, `iss`, `nbf`, `sub` claims are verified
- Symmetric Encryption
    - `NONE`, `HS256`, `HS384`, `HS512` algorithms supported
- Asymmetric Encryption
    - `RS256`, `RS384`, `RS512` algorithms supported
    - `ES256`, `ES384`, `ES512`, `PS256`, `PS384`, `PS512` algorithms are planned

This library is not susceptible to the [recently discussed encryption vulnerability](https://auth0.com/blog/2015/03/31/critical-vulnerabilities-in-json-web-token-libraries/).

## Installation

```
composer require emarref/jwt
```

## Usage

Create an instance of the `Emarref\Jwt\Token` class, then configure it.

```php
use Emarref\Jwt\Claim;

$token = new Emarref\Jwt\Token();

// Standard claims are supported
$token->addClaim(new Claim\Audience(['audience_1', 'audience_2']));
$token->addClaim(new Claim\Expiration(new \DateTime('30 minutes')));
$token->addClaim(new Claim\IssuedAt(new \DateTime('now')));
$token->addClaim(new Claim\Issuer('your_issuer'));
$token->addClaim(new Claim\JwtId('your_id'));
$token->addClaim(new Claim\NotBefore(new \DateTime('now')));
$token->addClaim(new Claim\Subject('your_subject'));

// Custom claims are supported
$token->addClaim(new Claim\PublicClaim('claim_name', 'claim_value'));
$token->addClaim(new Claim\PrivateClaim('claim_name', 'claim_value'));
```

To use a token, create a JWT instance.

```php
$jwt = new Emarref\Jwt\Jwt();
```

To retrieve the encoded token for transfer, call the `serialize()` method.

```php
$algorithm = new Emarref\Jwt\Algorithm\None();
$encryption = Emarref\Jwt\Encryption\Factory::create($algorithm);
$serializedToken = $jwt->serialize($token, $encryption);
```

The `$serializedToken` variable now contains the unencrypted base64 encoded string representation of your token. To encrypt a token, pass an instance of `Emarref\Jwt\Encryption\EncryptionInterface` to the `serialize()` method as the second argument.

```php
$algorithm = new Emarref\Jwt\Algorithm\Hs256('verysecret');
$encryption = Emarref\Jwt\Encryption\Factory::create($algorithm);
$serializedToken = $jwt->serialize($token, $encryption);
```

An example of using Rs256 encryption with a key pair can be found in the wiki - [Using RS256 Encryption](https://github.com/emarref/jwt/wiki/Using-RS256-Encryption).

To use a serialized token, first deserialize it into a `Emarref\Jwt\Token` object using a `Jwt` instance.

```php
$token = $jwt->deserialize($serializedToken);
```

To verify a token's claims, first set up the context that should be used to verify the token against. Encryption is the only required verification.

```php
$context = new Emarref\Jwt\Verification\Context($encryption);
$context->setAudience('audience_1');
$context->setIssuer('your_issuer');
```

Then use the `verify()` method on a `Jwt` instance.
 
```php
try {
    $jwt->verify($token, $context);
} catch (Emarref\Jwt\Exception\VerificationException $e) {
    echo $e->getMessage();
}
```
## Testing

This library uses PHPUnit for unit testing. Make sure you've run `composer install` then call:
 
```
./bin/phpunit ./test
```

## Further Reading

- [JSON Web Encryption (JWE)](https://tools.ietf.org/html/draft-ietf-jose-json-web-encryption-36)
- [JSON Web Signature (JWS)](https://tools.ietf.org/html/draft-ietf-jose-json-web-signature-36)
- [JSON Web Algorithms (JWA)](https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-36)
- [JSON Web Key (JWK)](https://tools.ietf.org/html/draft-ietf-jose-json-web-key-36)
- [http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html](http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html)
