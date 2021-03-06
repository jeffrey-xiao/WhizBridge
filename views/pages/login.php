<div style="text-align:center">
    <div style = "height: 400px;"><img src = "/resources/WhizBridge-Logo.png" style = "height:400px;"></div>
  <div id = "createButton" class = "dropdownButton"><h1>Create a Job</h1></div>
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
		<div class = "formBody">
			<div class = "leftFields">
			  Username: <br>
			  Password: <br>
			</div>
			<div class = "rightFields">
			   <input type="text" name="username"><br>
			   <input type="password" name="password"><br>
			</div>
		</div>
		<br>
		<div class = "submit">
			<input type="submit" value="Login">
		</div>
    </form>
  </div>
  <div id = "registerButton" class = "dropdownButton"><h1>Register</h1></div>
  <div id = "registerForm" class = "dropdownBody" style = "display:none">
    <form action="attemptRegistration" method="post">
		<div class = "formBody">
			<div class = "leftFields">
			  Username: <br>
			  Password: <br>
			  Confirm Password: <br>
			  Full Name: <br>
			  Email: <br>
			</div>
			<div class = "rightFields">
			   <input type="text" name="username"><br>
			   <input type = "password" name = "password"><br>
			   <input type = "password" name = "password2"><br>
			   <input type="text" name="full_name"><br>
			   <input type="text" name="email"><br>
			</div>
		</div>
		<br>
		<div class = "submit">
			<input type="submit" value="Register">
		</div>
    </form>
  </div>
  <br>

<div class="about">
  <h1>About</h1>
  <p>WhizBridge is an interface designed to provide tech support. Whizzes, the suppliers in this market, are connected to individual nearby customers. Customers can request service calls through a web interface, text messaging, or an iOS application. Prices are determined by market conditions in the area, benefitting both the consumer and the producers. Security is guaranteed through a two-factor authentication system, with payment being processed through a third party service. Bridge with a Whiz today!</p>
    <div class="features">
    <h1>Features</h1>
    <li>No registration needed</li>
    <li>Seamless payment system</li>
    <li>Web, SMS, and iOS compatible</li>
    <li>Customer-centric marketplace</li>
    <li>Distributed service network</li>
    <li>Simple user interface</li>
    <li>100% commitment to privacy</li>
    </div>
</div>

    <div class="faq">
  <h1>FAQ</h1>
  <h2>What is this service?</h2>
  <p>This service is a distributed tech support network. Both customers and suppliers are individuals, with no corporate involvement.</p>
  <h2>How is this service secure?</h2>
  <p>Both the customer and the Whiz must agree on a transaction for money to exchange hands. In addition, our system is protected through a series of industry-standard encryption practices, including the utilization of Braintree to secure credit card and paypal payments.</p>
  <h2>What is the quality of this service?</h2>
  <p>Quality is guarantered through a certification program, with Whizzes progressing through a series of increasingly advanced examinations in order to participate in this market. This ensures that the customers always receive quality tech support services.</p>
  <h2>How much does this service cost?</h2>
  <p>Costs are entirely determined by the customer, with a naturally adjusting market. Customers who set their prices too low, will eventually adjust their prices up to obtain the required service. Customers who price their service calls too high, will obtain faster service at a higher monetary cost.</p>
    </div>
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