<?php
/**
* Magento REST API v2 - Update product Example w/ multistore details
* The users and roles should be created under System -> Webservices -> REST ...
*
* @author Ricardo Martins www.magenteiro.com/backend
* @link http://www.magentocommerce.com/api/soap/catalog/catalogProduct/catalog_product.update.html
*
*
* Some performance hints
* - Enable zlib.output_compression on .htaccess
* - Enable APC and configure it in magento config.xml
* - Optimize my.cnf (see http://www.magentocommerce.com/boards/viewthread/36225/) 
**/


### CONFIG AREA ###
$store_url = 'http://cursoback.local.com.br/';
$wsdl_url = $store_url . 'api/v2_soap/?wsdl';
$api_user = 'magenteiro';
$api_key = 'magenteiro123';

#ini_set("soap.wsdl_cache_enabled", 0);  //desabilita cache do wsdl do php - recomendavel qdo houver alteracao no wsdl

$sku = '1030000011';
$nova_descricao = 'Nova Descrição do produto.';
$visao = null;  //ex: english
### END CONFIG ###


echo "<p>WSDL Url: " . $wsdl_url . "</p>";

//profiller
$time_start = microtime(true);

//starting soapclient
$client = new SoapClient($wsdl_url);

//Getting a sessionId
$session = $client->login($api_user, $api_key);





echo sprintf("<p>Got session id: %s</p>", $session);
echo sprintf("<p>Time to get session id: %s</p>", microtime(true)-$time_start);

try{



  $result = $client->catalogProductUpdate($session, $sku, (object)array(
            'description' => $nova_descricao,
        ),$visao,'sku');

    var_dump($result);
}catch (SoapFault $e){
    var_dump($e);
}



//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);