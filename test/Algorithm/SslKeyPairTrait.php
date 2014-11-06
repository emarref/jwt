<?php


namespace Emarref\Jwt\Algorithm;


trait SslKeyPairTrait
{
    protected function generateKeyPair($algorithm)
    {
        $config = [
            'digest_alg' => $algorithm
        ];

        $keys_resource = openssl_pkey_new($config);
        openssl_pkey_export($keys_resource, $private_key);

        $public_key_details = openssl_pkey_get_details($keys_resource);
        $public_key = $public_key_details['key'];
        return ['private' => $private_key, 'public' => $public_key];
    }
}
 