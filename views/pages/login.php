<div style="text-align:center">
  <div id = "createButton" class = "dropdownButton"><h1>Create Job</h1></div>
  <div id = "createForm" class = "dropdownBody" style = "display:none">
    <form action="postJob" method="post">
        <div class = "formBody">
		<div class = "leftFields">
          Job Name: <br>
          Job Description: <br>
          Price: <br>
          Address: <br>
          Email: <br>
          Card Number: <br>
          Expiration Date: <br>
          CVV: <br>
          Billing Address Line 1: <br>
          Billing Address Line 2: <br>
          City: <br>
          State/Province: <br>
          Country: <br>
          Postal Code: <br>
          Cardholder Name: <br>
        </div>
        <div class = "rightFields">
           <input type="text" name="job_name"><br>
           <input type="text" name="job_description"><br>
           <input type="text" name = "job_price"><br>
           <input type = "text" name = "address"><br>
           <input type = "text" name = "email"><br>
           <input data-braintree-name="number" value=""><br>
           <input data-braintree-name="expiration_date" value=""><br>
           <input data-braintree-name="cvv" value=""><br>
           <input data-braintree-address1="address1" value=""><br>
           <input data-braintree-address2="address2" value=""><br>
           <input data-braintree-city="city" value=""><br>
           <input data-braintree-pronvince="province" value=""><br>
           <input data-braintree-country="country" value=""><br>
           <input data-braintree-name="postal_code" value=""><br>
           <input data-braintree-name="cardholder_name" value=""><br>
        </div>
		
		</div>
		<br>
		<div class = "submit">
			<input type="submit" id="submit" value="Pay and Submit">
		</div>
        
    </form>
  </div>
  <div id = "loginButton" class = "dropdownButton"><h1>Login</h1></div>
  <div id = "loginForm" class = "dropdownBody" style = "display:none">
    <form action="attemptLogin" method="post">
        <table align = "center">
          <tr> <td style="float:right"> Username: </td> <td> <input type="text" name="username"> </td> </tr>
          <tr> <td style="float:right"> Password: </td> <td> <input type="password" name="password"> </td> </tr>
        </table>
        <input type="submit" value="Login">
    </form>
  </div>
  <div id = "registerButton" class = "dropdownButton"><h1>Register</h1></div>
  <div id = "registerForm" class = "dropdownBody" style = "display:none">
    <form action="attemptRegistration" method="post">
        <table align = "center">
          <tr> <td style="float:right">Username:</td> <td> <input type="text" name="username"> </td></tr>
          <tr> <td style="float:right">Password: </td> <td> <input type = "password" name = "password"> </td> </tr>
          <tr> <td style="float:right">Confirm Password: </td> <td> <input type = "password" name = "password2"></td> </tr>
          <tr> <td style="float:right">Full Name: </td><td> <input type="text" name="full_name"></td> </tr>
          <tr> <td style="float:right">Email: </td><td> <input type="text" name="email"></td> </tr>
        </table>
        <input type="submit" value="Register">
    </form>
  </div>
  <br>


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
</div>
<script>
$("#createButton").click(function () {
  if ($("#createForm").is(':hidden')) {
    $( "#createForm" ).slideDown( "slow" );
  } else {
    $("#createForm").slideUp("slow");
  }
});
</script>
<script>
$("#loginButton").click(function () {
  if ($("#loginForm").is(':hidden')) {
    $( "#loginForm" ).slideDown( "slow" );
  } else {
    $("#loginForm").slideUp("slow");
  }
});
</script>
<script>
$("#registerButton").click(function () {
  if ($("#registerForm").is(':hidden')) {
    $( "#registerForm" ).slideDown( "slow" );
  } else {
    $("#registerForm").slideUp("slow");
  }
});
</script>