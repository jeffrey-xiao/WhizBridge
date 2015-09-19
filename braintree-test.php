<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 2015-09-19
 * Time: 1:54 AM
 */

require "braintree-php/lib/Braintree.php";
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('f8hz5cfs97665c2r');
Braintree_Configuration::publicKey('289njc8rrdf47cwk');
Braintree_Configuration::privateKey('e23e1e9b16adfccd3208096b42bba5a9');

echo($clientToken = Braintree_ClientToken::generate());

//Process payment
$nonce = $_POST["payment_method_nonce"];
/* Use payment method nonce here */

//Amount of payment
$amount = $_POST["payment_amount"];

$result = Braintree.Transaction::sale([
        'amount' => $amount,
        'paymentMethodNonce' => $nonce
    ]);
