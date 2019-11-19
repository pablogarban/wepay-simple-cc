<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>WePay - Simple CC integration</title>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
    </head>
    <body>
		<div id="wrapper">
			<div id="container">
				<div id="welcome">
					<h1><span>WePay - Simple CC integration</h1>
				</div>
				<div class="container">
					<form id="payment-form" novalidate action="process.php" method="post">
						<div class="form-field">
							<label>Name:</label>
							<input id="name" type="text">
						</div>
						<div class="form-field">
							<label>Email:</label>
							<input id="email" type="text">
						</div>
						<div class="form-field">
							<label>Card Number:</label>
							<input id="cc-number" type="text">
						</div>
						<div class="form-field">
							<label>Exp. Month:</label>
							<input id="cc-month" type="text">
						</div>
						<div class="form-field">
							<label>Exp. Year:</label>
							<input id="cc-year" type="text">
						</div>
						<div class="form-field">
							<label>CVV:</label>
							<input id="cc-cvv" type="text">
						</div>
						<div class="form-field">
							<label>Postal Code:</label>
							<input id="postal_code" type="text">
						</div>
						<input type="hidden" id="amount" name="amount" value="1">
						<input type="hidden" id="card-id" name="card">
						<button id="cc-submit" type="button">PAY $1.00</button>
					</form>
				</div>
			</div>
		</div>
        <script type="text/javascript" src="https://static.wepay.com/min/js/tokenization.4.latest.js"></script>
		<script type="text/javascript">
		(function() {
			WePay.set_endpoint("stage"); // -- CHANGE TO "PRODUCTION" WHEN LIVE --
			// Shortcuts
			var d = document;
				d.id = d.getElementById,
				valueById = function(id) {
					return d.id(id).value;
				};
			// For those not using DOM libraries
			var addEvent = function(e,v,f) {
				if (!!window.attachEvent) { e.attachEvent('on' + v, f); }
				else { e.addEventListener(v, f, false); }
			};
			// Attach the event to the DOM
			addEvent(d.id('cc-submit'), 'click', function() {
				var userName = [valueById('name')].join(' ');
				response = WePay.credit_card.create({
					"client_id":        123456, // -- CLIENT ID --
					"user_name":        valueById('name'),
					"email":            valueById('email'),
					"cc_number":        valueById('cc-number'),
					"cvv":              valueById('cc-cvv'),
					"expiration_month": valueById('cc-month'),
					"expiration_year":  valueById('cc-year'),
					"address": {
						"postal_code": valueById('postal_code')
					}
				}, function(data) {
					if (data.error) {
						//ERROR
						alert(data.error_description);
					} else {
						//SUCCESS
						document.getElementById("card-id").value = data.credit_card_id;
						document.getElementById("payment-form").submit();

					}
				});
			});
		})();
		</script>
    </body>
</html>
