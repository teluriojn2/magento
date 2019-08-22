<?php
/**
* Magento REST API v2 - Check and update item qty from inventory
* The users and roles should be created under System -> Webservices -> REST ...
* @author Ricardo Martins www.magenteiro.com/backend
* @link http://www.magentocommerce.com/api/soap/catalogInventory/Inventory.html
*
*
* Some performance hints
* - Enable zlib.output_compression on .htaccess
* - Enable APC and configure it in magento config.xml
* - Optimize my.cnf (see http://www.magentocommerce.com/boards/viewthread/36225/) 
**/

### CONFIG AREA - Change as your needs###
$store_url = 'http://cursoback.local.com.br/';
$wsdl_url = $store_url . 'api/v2_soap/?wsdl';
$api_user = 'magenteiro';
$api_key = 'magenteiro123';

//multiplos skus e qtds
$multiUpdate = array(
    '127096' => array(
        'qty' => 10,
        'is_in_stock' => 1
    ),
    '127095' => array(
        'qty' => 20,
        'is_in_stock' => 1
    ),
    '127094' => array(
        'qty' => 12,
        'is_in_stock' => 1
    ),
    '127094' => array(
        'qty' => 12,
        'is_in_stock' => 1
    ),
    '127099' => array(
        'qty' => 12,
        'is_in_stock' => 1
    ),
    '127097' => array(
        'qty' => 2,
        'is_in_stock' => 1
    ),
);
### END CONFIG ###


echo "<p>WSDL Url: " . $wsdl_url . "</p>";

//profiller
$time_start = microtime(true);

//starting soapclient
$proxy = new SoapClient($wsdl_url);

//Getting a sessionId
$sessionId = $proxy->login($api_user, $api_key);





echo sprintf("<p>Got session id: %s</p>", $sessionId);
echo sprintf("<p>Time to get session id: %s</p>", microtime(true)-$time_start);




//setting new inventory info
$update_start = microtime(true);
$result = $proxy->catalogInventoryStockItemMultiUpdate($sessionId, array_keys($multiUpdate), $multiUpdate);
echo "Result: " . var_export($result, true);

$update_time = microtime(true) - $update_start;
echo '<br/>catalogInventoryStockItemMultiUpdate duration: ' . $update_time .' seconds';
//$proxy->call($sessionId, 'product_stock.update', array($sku, array('qty'=>50, 'is_in_stock'=>1)));

//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);