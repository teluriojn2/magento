<?php
/**
* Magento SOAP API v2 - Get session
* The users and roles should be created under System -> Webservices -> SOAP ...
* @author Ricardo Martins - www.magenteiro.com/backend
* @link http://devdocs.magento.com/guides/m1x/api/soap/introduction.html#Introduction-SOAPAPIVersionv2
*
*
* Some performance hints
* - Enable zlib.output_compression on .htaccess
* - Enable APC and configure it in magento config.xml
* - Optimize my.cnf (see http://www.magentocommerce.com/boards/viewthread/36225/)
*
* On Server:
*  Don't forget to set always_populate_raw_post_data = -1
**/

### CONFIG AREA - Change as your needs###
ini_set("soap.wsdl_cache_enabled", 0);
ini_set("soap.wsdl_cache", 0);
ini_set("error_reporting", -1);
ini_set("display_errors", 'On');

$store_url = 'http://cursoback.local.com.br/';
$wsdl_url = $store_url . 'api/v2_soap/?wsdl';
$api_user = 'jn2';
$api_key = 'teste123123';


### END CONFIG ###

echo "<p>WSDL Url: " . $wsdl_url . "</p>";

//profiller
$time_start = microtime(true);

//starting soapclient
$proxy = new SoapClient($wsdl_url, ['soap_version'=>SOAP_1_1]);

//Getting a sessionId
$sessionId = $proxy-> login(['username'=>$api_user, 'apiKey'=>$api_key]);


//var_dump($sessionId);


echo sprintf("<p>Got session id: %s</p>", $sessionId->result);
echo sprintf("<p>Time to get session id: %s</p>", microtime(true)-$time_start);



//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);