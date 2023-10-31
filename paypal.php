<?php
require_once 'vendor/autoload.php';
 
use PayPalApiItem;
use PayPalApiItemList;
 
$apiContext = new PayPalRestApiContext(
    new PayPalAuthOAuthTokenCredential(
        'YOUR_CLIENT_ID',     // ClientID
        'YOUR_CLIENT_SECRET'  // ClientSecret
    )
);
 
$apiContext->setConfig(
    array(
        'log.LogEnabled' => true,
        'log.FileName' => 'PayPal.log',
        'log.LogLevel' => 'DEBUG',
        'mode' => 'sandbox', //'live' or 'sandbox'
    )
);
 
$payer = new PayPalApiPayer();
$payer->setPaymentMethod('paypal');
 
$item1 = new Item();
$item1->setName($_POST['item'])
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setPrice($_POST['amount']);
 
$itemList = new ItemList();
$itemList->setItems(array($item1));
 
$amount = new PayPalApiAmount();
$amount->setTotal($_POST['amount']);
$amount->setCurrency('USD');
 
$transaction = new PayPalApiTransaction();
$transaction->setDescription("Payment For Service")
            ->setItemList($itemList)
            ->setAmount($amount);
 
$redirectUrls = new PayPalApiRedirectUrls();
$redirectUrls->setReturnUrl("YOUR_HTTP_PATH/success.php")
    ->setCancelUrl("YOUR_HTTP_PATH/error.php");
 
$payment = new PayPalApiPayment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);
 
// 4. Make a Create Call
try {
    $payment->create($apiContext);
 
    header('Location: '. $payment->getApprovalLink());
}
catch (PayPalExceptionPayPalConnectionException $ex) {
    // This will print the detailed information on the exception.
    //REALLY HELPFUL FOR DEBUGGING
    echo $ex->getData();
}
?>