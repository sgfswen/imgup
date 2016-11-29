<?php
return array(
    'jwt' => array(
        'key'       => 'X+JXxvIufbU7k7qYViLbTkOCmNbPA1cXSEEnWIer5NSuHiFGIiGFJiGFiuTaLkCvz+Q4CgKnI71NuwzpRKmZyQ==',     // Key for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
        'algorithm' => 'HS512' // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        ),
    'database' => array(
        'user'     => 'wpf8741', // Database username
        'password' => 'Gcma5EB$', // Database password
        'host'     => 'aa182ertcdn20c2.cr86zq8cwyiy.us-east-2.rds.amazonaws.com', // Database host
        'name'     => 'wpf8741', // Database schema name
    ),
    'serverName' => 'imgup',
);