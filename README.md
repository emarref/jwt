### Work in Progress

Intended to eventually be a full implementation of the JWT standard.

- [JSON Web Token (JWT)](https://tools.ietf.org/html/draft-ietf-oauth-json-web-token-30)
- [JSON Web Encryption (JWE)](https://tools.ietf.org/html/draft-ietf-jose-json-web-encryption-36)
- [JSON Web Signature (JWS)](https://tools.ietf.org/html/draft-ietf-jose-json-web-signature-36)
- [JSON Web Algorithms (JWA)](https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-36)
- [JSON Web Key (JWK)](https://tools.ietf.org/html/draft-ietf-jose-json-web-key-36)

### More info

- [http://jwt.io/](http://jwt.io/)
- [http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html](http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html)

### Functional example

```php
require_once 'vendor/autoload.php';

$jwt = new \Emarref\Jwt\Jwt();

$token = new \Emarref\Jwt\Token();
$token->addClaim(new \Emarref\Jwt\Claim\Issuer('uri://foobar'));
$token->addClaim(new \Emarref\Jwt\Claim\Expiration(new \DateTime('30 minutes')));

$encodedToken = $jwt->serialize($token, new \Emarref\Jwt\Algorithm\Hs256('verysecret'));
// -> eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1cmk6XC9cL2Zvb2JhciIsImV4cCI6MTQxNTA3MTMxNX0.mf2LLMA1fzd04L5438JcBwWyx9l7rY1_mHBiwrOxpDs

$token = $jwt->deserialize('eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1cmk6XC9cL2Zvb2JhciIsImV4cCI6MTQxNTA3MTMxNX0.mf2LLMA1fzd04L5438JcBwWyx9l7rY1_mHBiwrOxpDs');
$context = new \Emarref\Jwt\Verification\Context();
$context->setAlgorithm(new \Emarref\Jwt\Algorithm\Hs256('verysecret'));
$context->setIssuer('uri://foobar');
var_dump($jwt->verify($token, $context));
// -> bool(true)
```
