<?php

require_once(__DIR__."/src/Store/DataStore.php");
require_once(__DIR__."/src/env.php");

$f = fopen(".log", "wb");
fwrite($f, "Revalidating...\n");

set_time_limit(0);

$client = new SoapClient("http://soap/subscription?wsdl");
$header = new SoapHeader("http://binotify.com", "ApiKey", getenv("API_KEY"));
$client->__setSoapHeaders($header);


$pendingSubs = $STORE->getPendingSubscriptions();

$updatedSubs = [];

if (count($pendingSubs) > 0) {
  foreach ($pendingSubs as $pendingSub) {
    $result = $client->__soapCall("getStatus", [
      "parameters" => [
      "arg0" => $pendingSub["creator_id"],
      "arg1" => $pendingSub["subscriber_id"]
    ]]);
    if (isset($result->return)) {
      if (strcmp($result->return, "ACCEPTED") == 0) {
        $pendingSub["status"] = "ACCEPTED";
        $updatedSubs[] = $pendingSub;
      }
      if (strcmp($result->return, "REJECTED") == 0) {
        $pendingSub["status"] = "REJECTED";
        $updatedSubs[] = $pendingSub;
      }
    }
  }
}

foreach ($updatedSubs as $sub) {
  fwrite($f, "Updating\n");
  fwrite($f, var_export($sub));
  $STORE->updateSubscription($sub["creator_id"], $sub["subscriber_id"], $sub["status"]);
}

