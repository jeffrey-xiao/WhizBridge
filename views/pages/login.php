<h1>Login</h1>
<form action="attemptLogin" method="post">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<input type="submit" value="Login">
</form>
<br>
<h1>Register</h1>
<form action="attemptRegistration" method="post">
Username: <input type="text" name="username"><br>
Password: <input type = "password" name = "password"><br>
Confirm Password: <input type = "password" name = "password2"><br>
Full Name: <input type="text" name="full_name"><br>
Email: <input type="text" name="email"><br>
<input type="submit" value="Register">
</form>
<br>
<h1>Create Job</h1>
<form action="postJob" method="post">
Job Name: <input type="text" name="job_name"><br>
Job Description: <input type="text" name="job_description"><br>
Price: <input type="text" name = "job_price"><br>
Address: <input type = "text" name = "address" value = "1 Abbey Rd, Welland, ON L3C 7L1"><br>
Email: <input type = "text" name = "email"> <br>
    Card Number: <input data-braintree-name="number" value=""> <br>
    Expiration Date: <input data-braintree-name="expiration_date" value=""> <br>
    CVV: <input data-braintree-name="cvv" value=""> <br>
    Billing Address Line 1: <input data-braintree-address1="address1" value=""> <br>
    Billing Address Line 2: <input data-braintree-address2="address2" value=""> <br>
    City: <input data-braintree-city="city" value=""> <br>
    State/Province: <input data-braintree-pronvince="province" value=""> <br>
    Country: <input data-braintree-country="country" value=""> <br>
    Postal Code: <input data-braintree-name="postal_code" value=""> <br>
    Cardholder Name: <input data-braintree-name="cardholder_name" value=""> <br>
    <input type="submit" id="submit" value="Pay and Submit">
</form>

<h1>About</h1>
<p>This is bullshit</p>

<h1>FAQ</h1>
<h2>What is this service?</h2>
<p>Smoke weed everyday</p>
<h2>What is this service?</h2>
<p>Smoke weed everyday</p>
<h2>What is this service?</h2>
<p>Smoke weed everyday</p>
<h2>What is this service?</h2>
<p>Smoke weed everyday</p>
<?php

?>

