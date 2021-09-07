<?php

namespace iPay\Api;

class Api {
	protected static $mobileMoneyURL = '';
	protected static $pesalinkURL = '';
	protected static $testURL = 'http://localhost/test_api/processor.php';
	protected static $vendorId = null;
	protected static $secretKey = null;

	public function __construct($vendorId, $secretKey)
	{
		$this->vendorId = $vendorId;
		$this->secretKey = $secretKey;
	}

	//demo mobile payment
	public function mobilMoneyPayment($amount, $phone, $email, $reference)
	{
		$datastring = "amount=" . $amount . "&phone=" . $phone . "&reference=" . $reference . "&vid=" . $this->vendorId;

		$hashid = hash_hmac("sha256", $datastring, $this->secretKey);

		$data = array(		    
		    'vid' => $this->vendorId,		    
		    'phone' => $phone,
		    'email' => $email,
		    'reference_number' => $reference ,
		    'currency' => 'KES',
		    'amount' => $amount
		);

		$response = $this->makeCURLRequest($this->$testURL, $data);

		return $response;
	}

	private function makeCURLRequest($url, $data){
		$ch = curl_init ($url); // your URL to send array data
		curl_setopt ($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Your array field
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);

		return $result;
	}
}