### Work in Progress

Intended to eventually be a full implementation of the JWT standard.

[JSON Web Token (JWT)](https://tools.ietf.org/html/draft-ietf-oauth-json-web-token-30)
[JSON Web Encryption (JWE)](https://tools.ietf.org/html/draft-ietf-jose-json-web-encryption-36)
[JSON Web Signature (JWS)](https://tools.ietf.org/html/draft-ietf-jose-json-web-signature-36)
[JSON Web Algorithms (JWA)](https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-36)
[JSON Web Key (JWK)](https://tools.ietf.org/html/draft-ietf-jose-json-web-key-36)

### More info

[http://jwt.io/](http://jwt.io/)  
[http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html](http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html)

### Functional example

```php
require_once 'vendor/autoload.php';

use Emarref\Jwt\Encryption\Strategy as EncryptionStrategy;
use Emarref\Jwt\Token\Header\Parameter;
use Emarref\Jwt\Token\Payload\Claim;

$jwt = new Emarref\Jwt\Jwt();
$jwt->registerEncryptionStrategy(new EncryptionStrategy\Hs256('secret'));
$token = $jwt->createToken();
$token->addClaim(new Claim\IssuerClaim('joe'));
$encodedToken = $jwt->encode($token);
$decodedToken = $jwt->decode($encodedToken);

var_dump($encodedToken);
var_dump($decodedToken->getHeader()->findParameterByName(Parameter\AlgorithmParameter::NAME)->getValue());
var_dump($decodedToken->getPayload()->findClaimByName(Claim\IssuerClaim::NAME)->getValue());
```
