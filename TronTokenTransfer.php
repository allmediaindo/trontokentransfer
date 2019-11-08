<?php

header("Content-Type: text/plain");


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

ini_set('precision', 12); 

ignore_user_abort(1); // run script in background
set_time_limit(30); // run script this many seconds


include_once "../../../../vendor/autoload.php";





// Security key to run this script must match whatever comes via the key REQUEST parameter
$temp_the_security_key = 'g5t9d2e';



$the_temp_show_debug_data = false;






$the_reward_to_give = 0;


$the_result_buffer_str = "";







// The wallet that gives the rewards
$the_tron_wallet_address = "DEFAULT SOURCE ADDRESS OR LEAVE BLANK";






$the_current_date = (string) date("Y-m-d");
$the_current_date = trim($the_current_date);


// Current seconds since 1970 and the seconds stored on file
// Comparing these to help prevent the script being run multiple times at the same exact time

$the_current_epoch_time = (int) time();
$the_epoch_filename = "epoch07.txt";
$the_saved_epoch_time = (int) file_get_contents($the_epoch_filename);
$the_seconds_elapsed = $the_current_epoch_time-$the_saved_epoch_time;



if($the_seconds_elapsed < 0) {$the_seconds_elapsed = 0;}




// Token ID   Could also be set to an incoming parameter to change it on the fly
$the_token_id = 1002577;










$the_tron_wallet_secret_pk = ""; // It is set later




// -----


$the_tron_wallet_secret_pk = "DEFAULT SOURCE WALLET PK OR LEAVE BLANK";








$the_tron_wallet_address_input = trim($_REQUEST['wallet']);

  if(strlen($the_tron_wallet_address_input) > 3) {$the_tron_wallet_address = $the_tron_wallet_address_input;}

$the_tron_wallet_secret_pk_input = trim($_REQUEST['walletpk']);


if(strlen($the_tron_wallet_secret_pk_input) > 3) {
$the_tron_wallet_secret_pk = $the_tron_wallet_secret_pk_input;

}









$temp_address_to = (string) trim($_REQUEST['dest']);
$the_reward_to_give_input = (int) trim($_REQUEST['amount']);

$the_security_key_input = trim($_REQUEST['key']);


// Convert incoming VirtualHash into SUN (Trons smallest units)
$the_reward_to_give = ($the_reward_to_give_input/100000);




// echo $the_reward_to_give;



if($the_security_key_input == $temp_the_security_key) {
if(strlen($temp_address_to) > 5) {
 if($the_reward_to_give > 0) {

$fullNode = new \IEXBase\TronAPI\Provider\HttpProvider("https://api.trongrid.io");
$solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider("https://api.trongrid.io");
$eventServer = new \IEXBase\TronAPI\Provider\HttpProvider("https://api.trongrid.io");


$transfer = Array();

try {
$tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);} catch (\IEXBase\TronAPI\Exception\TronException $e) {$the_result_buffer_str .= 'Tron WARNING: '.$e->getMessage();}






$tron->setAddress($the_tron_wallet_address);
$tron->setPrivateKey($the_tron_wallet_secret_pk);




// $aaa = $tron->getTokenFromID((string) $the_token_id);


// var_dump($aaa);


// echo "<br><br><br><hr><hr><br>";






try {

// If you want to just send TRX uncomment this and edit appropriately 
// This sends 1 TRX for example

// $transfer = $tron->send('TRON_ADDRESS', 1);







if($the_seconds_elapsed > 3) {

if($the_reward_to_give_input >= 10) {

 if($temp_address_to != $the_tron_wallet_address) {
 

$the_token_balance = (int) $tron->getTokenBalance($the_token_id, $temp_address_to);

$the_result_buffer_str .= '[ Attempt to send '.$the_reward_to_give.' VRT to '.$temp_address_to;



$transfer = $tron->sendTokenTransaction($temp_address_to, $the_reward_to_give, $the_token_id); 


$transfer_json = json_encode($transfer);

echo $transfer_json;



  } // End if not sender wallet

} else {echo '{"result":false, "error":true, "message":"Amount must be bigger than 10"}';}
// End if reward to give

} else {echo '{"result":false, "error":true, "message":"Sending requests too fast"}';}

} catch (\IEXBase\TronAPI\Exception\TronException $e) {

$bbb001 = $e->getMessage();

$the_result_buffer_str .= $bbb001;

echo $bbb001;
}










$the_result_buffer_str .= '- - - - - - - - - -';

// var_dump($tron->listSuperRepresentatives());


// var_dump($tron->getBalance(null, true));

// $tron->toHex("TT67rPNwgmpeimvHUMVzFfKsjL9GZ1wGw8");

// result: 41BBC8C05F1B09839E72DB044A6AA57E2A5D414A10

// $tron->fromHex("41BBC8C05F1B09839E72DB044A6AA57E2A5D414A10");

// var_dump($tron->getTransaction("TxId"));





/*
$the_file_out1 = fopen("lastdate.txt", "w");
fwrite($the_file_out1, $the_current_date);
fclose($the_file_out1);
*/

$the_file_out2 = fopen($the_epoch_filename, "w");
fwrite($the_file_out2, (string) $the_current_epoch_time);
fclose($the_file_out2);





// The result of the operation

$the_result_buffer_str .= ' - - - [ Date: '.date("Y-m-d H:i:s").' ] - - - ENTRY END - - -';


$the_node_log_filename1 = "logapi.txt";
$the_node_log_file_out1 = fopen($the_node_log_filename1,"w");
fwrite($the_node_log_file_out1,$the_result_buffer_str);
fclose($the_node_log_file_out1);

} else {echo '{"result":false, "error":true, "message":"Amount must be bigger than 10"}';}

} else {



echo '{"result":false, "error":true, "message":"Destination address cannot be empty"}';

}
// End if str len


} else {echo '{"result":false, "error":true, "message":"Invalid key"}';}

// End if security key

?>