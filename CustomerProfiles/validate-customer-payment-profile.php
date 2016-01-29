<?php
  require 'vendor/autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;
  
  function validateCustomerPaymentProfile($customerProfileId= \SampleCode\Constants::CUSTOMER_PROFILE_ID_2,
    $customerPaymentProfileId= \SampleCode\Constants::CUSTOMER_PAYMENT_PROFILE_ID_GET)
  {
  // Common setup for API credentials
  $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
  $merchantAuthentication->setName(\SampleCode\Constants::MERCHANT_LOGIN_ID);
  $merchantAuthentication->setTransactionKey(\SampleCode\Constants::MERCHANT_TRANSACTION_KEY);
  
  // Use an existing payment profile ID for this Merchant name and Transaction key
  //validationmode tests , does not send an email receipt
  $validationmode = "testMode";

  $request = new AnetAPI\ValidateCustomerPaymentProfileRequest();
  
  $request->setMerchantAuthentication($merchantAuthentication);
  $request->setCustomerProfileId($customerProfileId);
  $request->setCustomerPaymentProfileId($customerPaymentProfileId);
  $request->setValidationMode($validationmode);
  
  $controller = new AnetController\ValidateCustomerPaymentProfileController($request);
  $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
  
  if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
  {
      echo $response->getMessages()->getMessage()[0]->getText();
   }
  else
  {
      echo "ERROR :  Validate Customer Payment Profile: Invalid response\n";
      echo "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText() . "\n";
  }
  return $response;
  }
  if(!defined('DONT_RUN_SAMPLES'))
      validateCustomerPaymentProfile();
 ?>
