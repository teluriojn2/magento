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

$marca = 'MAGENTEIROROUPAS'; //Nome do fabricante (manufacturer desejado - deve estar cadastrado)
//ini_set("soap.wsdl_cache_enabled", 0);  //desabilita cache do wsdl do php - recomendavel qdo houver alteracao no wsdl
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
    // get attribute set
    $attributeSets = $client->catalogProductAttributeSetList($session);
    $attributeSet = current($attributeSets);

    $productName = 'Product from API ' . rand (0,999999);
    $sku = uniqid('FROMAPI', true);

    #BEGIN especifico para loja com atributos personalizados
    //pegar Id de atributos especificos..

    //buscando id de atributos especificos
    $manufacturerAttributeOptions = $client->catalogProductAttributeOptions($session,'manufacturer');
    $desiredValue = $marca; //valor textual do atributo desejado
    $manufacturerId = '';
    foreach ($manufacturerAttributeOptions as $k => $option) {
        if($option->label==$desiredValue){
            $manufacturerId = $option->value;
            break;
        }
    }

    echo 'Manufacturer ID: '. $manufacturerId . '<br/>';
    #END especifico para loja com atributos personalizados


    $result = $client->catalogProductCreate($session, 'simple', $attributeSet->set_id, $sku, array(
//            'categories' => array(2),
            'websites' => array(1),
            'name' => $productName,
            'description' => 'Product description',
            'short_description' => 'Product short description',
            'weight' => '10',
            'status' => '1',
            'url_key' => 'product-url-key',
            'url_path' => 'product-url-path',
            'visibility' => '4',
            'price' => '100',
            'tax_class_id' => '0',
            'meta_title' => 'Product meta title',
            'meta_keyword' => 'Product meta keyword',
            'meta_description' => 'Product meta description',
            'manufacturer'=> $manufacturerId,
            'stock_data' => array(
                'use_config_manage_stock' => true
            ),


            #attributos personalizados - mapeados pelos seus modulos
            'additional_attributes'=>array(
                'single_data' => array(
                    array(
                        'key'=>'manufacturer',
                        'value' => $manufacturerId,  //atributo dropdown, pasamos o id
                    ),
                    array(
                        'key' => 'referencia',
                        'value' => 'referencia' . rand(1,999),
                    ),
                    array(
                        'key'=>'color',
                        'value'=> 53,
                    ),
                    array(
                        'key'=>'tamanho',
                        'value'=> 41,
                    ),
                    array(
                        'key'=> 'tipo_produto',
                        'value'=>'ADULTO',
                    ),
                    array(
                        'key'=> 'grupo_produto',
                        'value'=>'Blusas e bodys',
                    ),
                    array(
                        'key'=> 'subgrupo_produto',
                        'value'=>'BLUSA',
                    ),
                    array(
                        'key'=> 'sexo_tipo',
                        'value'=>'FEMININO',
                    ),
                    array(
                        'key'=> 'linha',
                        'value'=>'PIJAMAS',
                    ),
                ),
            ),
        ));

    var_dump($result);
}catch (SoapFault $e){
    var_dump($e);
}



//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);