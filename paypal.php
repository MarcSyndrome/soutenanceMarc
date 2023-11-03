<?php
require_once 'vendor/autoload.php';

 // On call les API
use PayPalApiItem;
use PayPalApiItemList;
 
$apiContext = new PayPalRestApiContext(
    new PayPalAuthOAuthTokenCredential(
        '18C713N7',     // ClientID
        '53C83780085'  // ClientSecret
    )
);
 
$apiContext->setConfig(
    array(
        'log.LogEnabled' => true,
        'log.FileName' => 'PayPal.log',
        'log.LogLevel' => 'DEBUG',
        'mode' => 'sandbox', //'live' or 'sandbox' Pour tests
    )
);

// Création client
$payer = new PayPalApiPayer(); 
$payer->setPaymentMethod('paypal');
 
// Création de l'objet vendu
$itemSold = new Item(); 
$itemSold->setName($_POST['item'])
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setPrice($_POST['amount']);
 
// Création de la liste qui contiendra les objets vendu
$itemList = new ItemList();
$itemList->setItems(array($itemSold));
 
// Création de la somme totale
$amount = new PayPalApiAmount(); 
$amount->setTotal($_POST['amount']);
$amount->setCurrency('USD');

// Regroupement de la liste et de la somme
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