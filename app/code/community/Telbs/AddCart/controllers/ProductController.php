<?php
class Telbs_AddCart_ProductController extends Mage_Core_Controller_Front_Action
{
    public function addAction()
    {
        $sku = $this->getRequest()->getParam('sku');

        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
        $cart = Mage::getSingleton('checkout/cart')->init();
        $cart->addProduct($product->getId());
        $cart->save();

        //$helper = Mage::helper('telbs_addcart1');
        //$helper->logToFile('Produc add cart: ', $sku);
        $this->_redirect('checkout/cart');

        //Retorno -- http://magento.loc/addcart/product/add/sku/teste

    }

}