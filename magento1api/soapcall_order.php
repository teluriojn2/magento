<?php
/**
* Magento REST API v2 - Create order Example
* The users and roles should be created under System -> Webservices -> REST ...
* @author Ricardo Martins www.magenteiro.com/backend
* @link http://www.magentocommerce.com/api/soap/checkout/cart/cart.order.html
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


$cartId = $proxy->shoppingCartCreate($sessionId, 1);
// load the customer list and select the first customer from the list
$customerList = $proxy->customerCustomerList($sessionId, array());
$customer = (array) $customerList[0];
$customer['mode'] = 'customer';
$proxy->shoppingCartCustomerSet($sessionId, $cartId, $customer);
// load the product list and select the first product from the list
$productList = $proxy->catalogProductList($sessionId);
$product = (array) $productList[0];
$product['qty'] = 1;
$proxy->shoppingCartProductAdd($sessionId, $cartId, array($product));

$address = array(
    array(
        'mode' => 'shipping',
        'firstname' => $customer['firstname'],
        'lastname' => $customer['lastname'],
        'street' => 'street address',
        'city' => 'city',
        'region' => 'region',
        'telephone' => 'phone number',
        'postcode' => 'postcode',
        'country_id' => 'country ID',
        'is_default_shipping' => 0,
        'is_default_billing' => 0
    ),
    array(
        'mode' => 'billing',
        'firstname' => $customer['firstname'],
        'lastname' => $customer['lastname'],
        'street' => 'street address',
        'city' => 'city',
        'region' => 'region',
        'telephone' => 'phone number',
        'postcode' => 'postcode',
        'country_id' => 'country ID',
        'is_default_shipping' => 0,
        'is_default_billing' => 0
    ),
);
 // add customer address
$proxy->shoppingCartCustomerAddresses($sessionId, $cartId, $address);
// add shipping method
$proxy->shoppingCartShippingMethod($sessionId, $cartId, 'flatrate_flatrate');

$paymentMethod =  array(
    'po_number' => null,
    'method' => 'checkmo',
    'cc_cid' => null,
    'cc_owner' => null,
    'cc_number' => null,
    'cc_type' => null,
    'cc_exp_year' => null,
    'cc_exp_month' => null
);
 // add payment method
$proxy->shoppingCartPaymentMethod($sessionId, $cartId, $paymentMethod);
 // place the order
$orderId = $proxy->shoppingCartOrder($sessionId, $cartId, null, null);



echo sprintf("<p>Order Id: %s</p>", $orderId);


//profiler
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("<hr/><small>Total execution time: %s seconds.</small>",$time);