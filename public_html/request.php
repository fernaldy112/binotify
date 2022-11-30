<?php

require_once(__DIR__."/../src/Store/DataStore.php");

// TODO: check login

$userId = $_SESSION["user_id"];
$artistId = $_POST["artist"];
$STORE->addSubscription($artistId, $userId);

$client = new SoapClient("http://soap/subscription?wsdl");
$header = new SoapHeader("http://binotify.com", "ApiKey", "8FX5S4ZSB6AJLN1JW0OZ");
$client->__setSoapHeaders($header);

$client->__soapCall("addNewSubscription", [
  "arg0" => $artistId,
  "arg1" => $userId
]);
