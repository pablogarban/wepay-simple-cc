<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>WePay - Simple CC integration</title>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
    </head>
    <body>
	<?php
	if(isset($_REQUEST['card']) && isset($_REQUEST['amount'])) {
		require_once('vendor/autoload.php');
		
		// application settings
		$account_id    = 123456;
		$client_id     = 123456;
		$client_secret = "123456";
		$access_token  = "STAGE_123456";			
		
		// change to useProduction for live environments
		\WePay::useStaging($client_id, $client_secret);
		
		$wepay = new \WePay($access_token);
		
		// charge the credit card
		$response = $wepay->request('checkout/create', array(
			'account_id'          => $account_id,
			'amount'              => 1,
			'currency'            => 'USD',
			'short_description'   => 'Testing',
			'type'                => 'goods',
			'payment_method'      => array(
				'type'            => 'credit_card',
				'credit_card'     => array(
					'id'          => 123456
				)
			)
		));
		
		// display the response
		if($response->state!='failed') {
			$message = "Thank you for your purchase!";
			$details="Transaction ID: ".$response->checkout_id;
		} else {
			$message = "Error!";
			$details = "Sorry, something went wrong";
		}
	?>
		
		<div id="wrapper">
			<div id="container">
				<div id="welcome">
					<h1><span>WePay - Simple CC integration</h1>
				</div>
				<h2><?php echo $message;?></h2>
				<h3><?php echo $details;?></h3>
			</div>
		</div>
		
	<?php
	}
	?>
	</body>
</html>
