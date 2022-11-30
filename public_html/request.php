<?php

require_once(__DIR__."/../src/Store/DataStore.php");

$f = fopen(".log", "wb");

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!array_key_exists("username", $_SESSION)) {
  header("Location: /login");
  return;
}

$_POST = json_decode(file_get_contents("php://input"), true);
$userId = (int) $_SESSION["user_id"];
$artistId = (int) $_POST["artist"];

$client = new SoapClient("http://soap/subscription?wsdl");
$header = new SoapHeader("http://binotify.com", "ApiKey", "PU66UGWTOBNJDA0JPL5K");
$client->__setSoapHeaders($header);

$client->__soapCall("addNewSubscription", [
  "parameters" => [
    "arg0" => $artistId,
    "arg1" => $userId
    ]]);
    
$STORE->addSubscription($artistId, $userId);