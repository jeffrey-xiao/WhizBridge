<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 2015-09-19
 * Time: 11:57 AM
 */
require ('braintree-php/lib/Braintree.php');
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('f8hz5cfs97665c2r');
Braintree_Configuration::publicKey('289njc8rrdf47cwk');
Braintree_Configuration::privateKey('e23e1e9b16adfccd3208096b42bba5a9');
?>
<form id="checkout" action="" method="post">
    <input data-braintree-name="number" value="4111111111111111">
    <input data-braintree-name="expiration_date" value="10/20">
    <input type="submit" id="submit" value="Pay">
</form>

<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<script>
    // We generated a client token for you so you can test out this code
    // immediately. In a production-ready integration, you will need to
    // generate a client token on your server (see section below).
    var clientToken = Braintree_ClientToken::generate();

    braintree.setup(clientToken, "dropin", {
        container: "payment-form"
    });
</script>