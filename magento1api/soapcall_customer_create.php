<?php
/**
* Magento REST API v2 - Create customer Example w/ multistore details
* The users and roles should be created under System -> Webservices -> REST ...
* @author Ricardo Martins - www.magenteiro.com/backend
* @link http://devdocs.magento.com/guides/m1x/api/soap/customer/customer.create.html
*
*
* Some performance hints
* - Enable zlib.output_compression on .htaccess
* - Enable APC and configure it in magento config.xml
* - Optimize my.cnf (see http://www.magentocommerce.com/boards/viewthread/36225/) 
**/
ini_set("soap.wsdl_cache_enabled", 0);


### CONFIG AREA ###
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

try{
    $email = 'teste'. rand(1,9999).'@lipsum.com.br';

    $result_create = $proxy->customerCustomerCreate($sessionId,array(
            'customer_id' => rand(10000,4294967295), #o customer_id pode ser passado na mao, se ja existir, fará update do cliente existente - até 4294967295
            'email' => $email,
            'firstname'=> 'Teste',
            'lastname'=> 'Cliente' . rand(1,999),
            'password'=>'123qwe',
            'website_id'=>2,
            'store_id' => 4,
            'group_id'=> 1,
            'taxvat' => '01234567890',
            'ie' => 'Isento', //inscricao estadual - apenas algumas lojas possuem


        ));
    $created_customer_id = $result_create;

    echo sprintf('<p>Customer <strong>%s (%s)</strong> created in %s seconds. Now creating it address...', $created_customer_id, $email, microtime(true)-$time_start);

    $result_address = $proxy->customerAddressCreate($sessionId, $created_customer_id, array(
            'firstname'=> 'Destinatario'. rand(1,300),
            'lastname'=> 'Sobrenome',
            'street' => array('endereco linha1', 'linha2'),
            'city' => 'Santos',
            'country_id' => 'BR',
            'region'=> 'São Paulo',
            'postcode'=> '11050230',
            'telephone' => '1331133300',
            'cellphone' => '13991278844',
            'address_number' => 'numero 123',
            'address_complement' => 'apto 345',
            'address_neighborhood' => 'Centro',
            'is_default_billing'=> true,
            'is_default_shipping' => true,

        ));

    var_dump($result_address);
}catch (SoapFault $e){
    var_dump($e);
}



//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);