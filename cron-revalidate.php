<?php

require_once(__DIR__."/src/Store/DataStore.php");

set_time_limit(0);
// sleep(300);

$client = new SoapClient("http://soap/subscription?wsdl");
$header = new SoapHeader("http://binotify.com", "ApiKey", "14Y3FE0J1MEXYMAI8XXB");
$client->__setSoapHeaders($header);

while (true) {
	echo "Revalidating ...\n";

  $pendingSubs = $STORE->getPendingSubscriptions();

  $accepteds = [];
  $rejecteds = [];

  if (count($pendingSubs) > 0) {
    foreach ($pendingSubs as $pendingSub) {
      $result = $client->__soapCall("getStatus", [
        "parameters" => [
        "arg0" => $pendingSub["creator_id"],
        "arg1" => $pendingSub["subscriber_id"]
      ]]);
      if (strcmp($result->return, "ACCEPTED") == 0) {
        $accepteds[] = $pendingSub;
      }
      if (strcmp($result->return, "REJECTED") == 0) {
        $rejecteds[] = $pendingSub;
      }
    }
  }

  // TODO: reflect changes to database


  sleep(20);
}
