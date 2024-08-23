<?php

/**
 * Get the client
 */
require_once __DIR__ . '/izipay_vendor/autoload.php';

/**
 * Define configuration
 */

/*------- Surco Test Corporacion Fedimar --------- */

/* Username, password and endpoint used for server to server web-service calls */
/* Lyra\Client::setDefaultUsername("95252157");
Lyra\Client::setDefaultPassword("testpassword_LT3PobdsI76AT4uL3zJVqb032VJN9Cslph0oWGupmihsg");
Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe"); */

/* publicKey and used by the javascript client */
/* Lyra\Client::setDefaultPublicKey("95252157:testpublickey_6gGngRgXu7KKjL1byseEitLPZe9LcFP7PuyvTRuvfY9o2"); */

/* SHA256 key */
/* Lyra\Client::setDefaultSHA256Key("KeTTLUn7zBaEPS4MczfSwJwavuElcGITptYEpDk0NrJGu"); */

/*------- /Surco Test Corporacion Fedimar --------- */

/*------- Surco Produccion Corporacion Fedimar --------- */

/* Username, password and endpoint used for server to server web-service calls */
Lyra\Client::setDefaultUsername("95252157");
Lyra\Client::setDefaultPassword("prodpassword_iR4QQ90g44Mx9EcUWmu0VSzMG2quiMR0IwcW8HHkbNSuS");
Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");

/* publicKey and used by the javascript client */
Lyra\Client::setDefaultPublicKey("95252157:publickey_2Q46sGL3c7W65FRlra1clsR52q4vTLPkxG8E9gZ1k4ddb");

/* SHA256 key */
Lyra\Client::setDefaultSHA256Key("WgyIGJdipurcJdqK8daykwuJwiSUMKB7sUgZQdulql30s");

/*------- /Surco Produccion Corporacion Fedimar --------- */
