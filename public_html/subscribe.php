<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once(__DIR__."/../src/Store/DataStore.php");

$soapIp = gethostbyname("soap");
$subscription = json_decode(file_get_contents("php://input"), true);

// Accept only request from SOAP server
if ($soapIp == $_SERVER["REMOTE_ADDR"]) {
  $creatorId = $subscription["creatorId"];
  $subscriberId = $subscription["subscriberId"];
  $status = $subscription["status"];
  $STORE->updateSubscription($creatorId, $subscriberId, $status);
}

