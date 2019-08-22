<?php
/**
* Magento REST API v2 - Create product Example w/ multistore details
* The users and roles should be created under System -> Webservices -> REST ...
* @author Ricardo Martins www.magenteiro.com/backend
* @link http://www.magentocommerce.com/api/soap/catalog/catalogProduct/catalog_product.create.html
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


    $session = $client->login($api_user, $api_key);
    //cadastrando preco no site 2

/*    $result2 = $client->catalogProductUpdate($session, $productId, (object)array(
           'price' => '200',
        ),'tabela_rs');*/
//    var_dump ($result,$result2);

    /*$result2 = $client->catalogProductUpdate($session, '000206                        ', (object)array(
            'price' => '2100',
            'tax_class_id' => '10', //ipi 15
        ),'tabela_rs','sku');*/

    /*
    $result2 = $client->catalogProductUpdate($session, '000206                        ', (object)array(
            'price' => '9900',
            'websites' => array(1,2),
            'manufacturer' => '332',
            'tax_class_id' => '10', //ipi 20
        ),'portuguese','sku');

        $result2 = $client->catalogProductUpdate($session, '000206                        ', (object)array(
                'price' => '4400',
                'websites' => array(1,2),
                'tax_class_id' => '12', //ipi 20
            ),'tabela_rs','sku');*/

    $result = $client->catalogInventoryStockItemUpdate($session, 113297, array(
            'qty' => '49',
            'is_in_stock' => 1,
            'manage_stock'=> 1,
        ));
$client->__getLastRequest();

    var_dump($result);
}catch (SoapFault $e){
    var_dump($e);
}



//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);