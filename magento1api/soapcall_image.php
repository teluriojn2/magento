<?php
/**
* Magento REST API v2 - Upload new image for a product
* The users and roles should be created under System -> Webservices -> REST ...
* @author Ricardo Martins www.magenteiro.com/backend
* @link http://www.magentocommerce.com/api/soap/catalog/catalogProductAttributeMedia/productImages.html
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

$filepath2upload = '/Users/martins/Documents/temporarios/vidal.jpg'; #full image file path - imagem que queremos mandar

$product_id = 476; #it is not sku, but product_id - ID do produto (não é SKU)
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


#getting the base64 of image content
$file = array(
	'content' 	=> base64_encode(file_get_contents($filepath2upload)),
	'name'		=> 'optional_imagename', #dont need extension
	'mime'		=> image_type_to_mime_type( exif_imagetype($filepath2upload) ) #will produce 'image/png' for example

	);

//getting current stock info
$result = $proxy->catalogProductAttributeMediaCreate(
	$sessionId,
	$product_id,
	array(
		'file'		=> $file,
		'label'		=> 'Vidal TXT',
		'position'	=> 100,
		'types'		=> array('thumbnail'),
		'exclude'	=> 0
		)
	);
echo '<hr/>';
echo 'Result: ' . var_export($result,true);


//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);