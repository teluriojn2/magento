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
$sku = array('008664'); //you can set multiple sku's
$new_qty = 10;
$is_in_stock = 1; # 0 = Out of stock;  1 = In stock
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

//getting current stock info
$result = $proxy->catalogInventoryStockItemList($sessionId, $sku);
echo '<hr/>';
foreach($result as $inventory){
    echo sprintf('<p><strong>Stock information for sku %s</strong></p>', $inventory->sku);
    echo sprintf('<p>Product ID: %s <br/>Qty: %s<br/>Is in stock: %s</p><hr/>', $inventory->sku, $inventory->qty, $inventory->is_in_stock);
}


//setting new inventory info
$update_start = microtime(true);
foreach($sku as $individualSku){
    $result = $proxy->catalogInventoryStockItemUpdate($sessionId, $individualSku, array(
            'qty' => $new_qty,
            'is_in_stock' => $is_in_stock,
        ));
    echo sprintf('<p>%s inventory information updated.</p>',$individualSku);

}
$update_time = microtime(true) - $update_start;
echo '<br/>catalogInventoryStockItemUpdate duration: ' . $update_time .' seconds';

//v1
//$proxy->call($sessionId, 'product_stock.update', array($sku, array('qty'=>50, 'is_in_stock'=>1)));

//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);