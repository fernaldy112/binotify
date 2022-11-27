<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once(__DIR__."/../src/Store/DataStore.php");

$soapIp = gethostbyname("soap");
$subscription = json_decode(file_get_contents("php://input"), true);

// Accept only request from SOAP server
if ($soapIp == $_SERVER["REMOTE_ADDR"]) {
  // TODO: update sub request given by $subscription
  
  
  
  // $f = fopen("test.txt", 'wb');
  // fwrite($f, $_SERVER["REMOTE_ADDR"]."\n");
  // fwrite($f, $soapIp."\n");
  // fwrite($f, $_SERVER["REMOTE_HOST"]."\n");
  // // fwrite($f, $_POST);
  // // fwrite($f, var_export($_POST));
  // foreach ($subscription as $key => $val) {
  //   fwrite($f, "$key : $val\n");
  // }
  // fclose($f);
}

