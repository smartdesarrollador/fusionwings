<?php

/**
 * Get the client
 */
require_once __DIR__ . '/izipay_vendor/autoload.php';

/**
 * Define configuration
 */

/*------- Lince Test Corporacion El Egipcio --------- */

/* Username, password and endpoint used for server to server web-service calls */
/* Lyra\Client::setDefaultUsername("39835468");
Lyra\Client::setDefaultPassword("testpassword_x4xLr2TvzJx7cJfeDgw5GaONyXrdPigPsB65FIepquR0x");
Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe"); */

/* publicKey and used by the javascript client */
/* Lyra\Client::setDefaultPublicKey("39835468:testpublickey_x6KMozSEUaXXJCnFbm3J4GqQdqc0cQM2XWysqiie9eX1i"); */

/* SHA256 key */
/* Lyra\Client::setDefaultSHA256Key("0oZJ8vZxKQPa5WduG7fUjsmidF6fNWATjXg0j7gjBU7yu"); */

/*------- /Lince Test Corporacion El Egipcio --------- */

/*------- Lince Produccion Corporacion El Egipcio --------- */

/* Username, password and endpoint used for server to server web-service calls */
Lyra\Client::setDefaultUsername("39835468");
Lyra\Client::setDefaultPassword("prodpassword_oZuohpLJXg20yaAEWfyOl3Eo2wGryoNeXRsZMrmflhHER");
Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");

/* publicKey and used by the javascript client */
Lyra\Client::setDefaultPublicKey("39835468:publickey_JXfRJSYBr68VSZZ04KlrzfkceV69Rld8AZrEmJ8jGCQ1D");

/* SHA256 key */
Lyra\Client::setDefaultSHA256Key("rLR2qbtgqlG70K4QWEhAbjiyl0GPBeyNEMmEj9vP6IfoT");

/*------- /Lince Produccion Corporacion El Egipcio --------- */
