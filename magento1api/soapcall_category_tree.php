<?php
/**
* Magento REST API v2 - Category Tree
* The users and roles should be created under System -> Webservices -> REST ...
* @author Ricardo Martins - www.magenteiro.com/backend
* @link http://www.magentocommerce.com/api/soap/catalog/catalogCategory/catalog_category.tree.html
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

$result = $proxy->catalogCategoryTree($sessionId,2);
echo sprintf("<p>Category Tree List (%s): %s</p>", count($result), '<pre>'.var_export
($result,true). '</pre>');



//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);