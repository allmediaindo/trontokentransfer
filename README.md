# trontokentransfer
PHP source code to send Tron (TRC10) tokens, using the IEXBase PHP Library


For this script to work, you need to have the Tron iexbase PHP API, which in turn requires to have PHP 7.1 or higher running on your server.

# Setup Guide


Step 1: Make sure you have a web host that support php 7.1 or above. You can login to your CPanel and check and upgrade if needed
Step 2: Login to your host using SSL and enter this command to install tron-api
  Once install, you need to know where the iexbase/tron-api has been install. In this case, it has been installed outside the public_html
  
Step 3: Create a php file in public_html and add following code:

(This is a sample code) 

-----

include_once ‘../vendor/autoload.php’;
$fullNode = new \IEXBase\TronAPI\Provider\HttpProvider(‘https://api.trongrid.io');
$solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider(‘https://api.trongrid.io');
$eventServer = new \IEXBase\TronAPI\Provider\HttpProvider(‘https://api.trongrid.io');
try {
$tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
} catch (\IEXBase\TronAPI\Exception\TronException $e) {
exit($e->getMessage());
}

-----

The include_once ‘../vendor/autoload.php’; may be located in a different directory on your server. Update as appropriate.

This guide was originally written by NAD and it explains it in detail:  https://medium.com/@nguynanhdng/install-and-use-tron-api-for-php-4dc786497bc




