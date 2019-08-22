<?php
/**
* Magento REST API v2 - Order Tracking code
* The users and roles should be created under System -> Webservices -> REST ...
* @author Ricardo Martins www.magenteiro.com/backend
* @link http://www.magentocommerce.com/api/soap/sales/salesOrderShipment/sales_order_shipment.create.html
* @link http://www.magentocommerce.com/api/soap/sales/salesOrderShipment/salesOrderShipment.html
* @link http://www.magentocommerce.com/api/soap/sales/salesOrderShipment/sales_order_shipment.addTrack.html
*
*
* Some performance hints
* - Enable zlib.output_compression on .htaccess
* - Enable APC and configure it in magento config.xml
* - Optimize my.cnf (see http://www.magentocommerce.com/boards/viewthread/36225/) 
**/

### CONFIG AREA ###
ini_set("soap.wsdl_cache_enabled", 0);  //desabilita cache do wsdl do php - recomendavel qdo houver alteracao no wsdl

$store_url = 'http://cursoback.local.com.br/';
$wsdl_url = $store_url . 'api/v2_soap/?wsdl';
$api_user = 'magenteiro';
$api_key = 'magenteiro123';

$order_increment_id = '200002328'; //ID do Pedido
$shipping_method = 'av5_correios'; //Codigo do metodo de envio utilizado
$shipping_tracking = 'EN24543543333BR'; //Codigo de rastreio
### END CONFIG ###


echo "<p>WSDL Url: " . $wsdl_url . "</p>";

//profiller
$time_start = microtime(true);

//starting soapclient
$proxy = new SoapClient($wsdl_url);

//Getting a sessionId
$sessionId = $proxy->login($api_user, $api_key);


//Criamos um shipment pra este pedido e guardamos o shipmentId que será usado na sequencia.
$newShipmentId = $proxy->salesOrderShipmentCreate($sessionId, $order_increment_id);


echo sprintf("<p>Got session id: %s</p>", $sessionId);
echo sprintf("<p>Time to get session id: %s</p>", microtime(true)-$time_start);

//Adicionamos o envio acima no pedido.
$result = $proxy->salesOrderShipmentAddTrack($sessionId, $newShipmentId, $shipping_method,'Correios',$shipping_tracking);
echo sprintf("<p>Order Track Added: %s</p>", '<pre>'.var_export($result,true). '</pre>');



//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);