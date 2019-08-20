<?php
class TelsTe_Telbs_IndexController extends Mage_Core_Controller_Front_Action {
    public function testAction()
    {
        $collection_of_products = Mage::getModel('catalog/product')->getCollection();
        var_dump($collection_of_products->getFirstItem()->getData());
    }

    public function test2Action()
    {
        $collection_of_products = Mage::getModel('catalog/product')->getCollection();
        //var_dump($collection_of_products->getSelect()); //might cause a segmentation fault
        var_dump(
            (string) $collection_of_products->getSelect()
        );
    }

    public function test3Action()
    {
        $collection_of_products = Mage::getModel('catalog/product')
            ->getCollection();
        $collection_of_products->addFieldToFilter('sku','teste');

        //another neat thing about collections is you can pass them into the count      //function.  More PHP5 powered goodness
        echo "Our collection now has " . count($collection_of_products) . ' item(s)';
        var_dump($collection_of_products->getFirstItem()->getData());
    }

    public function populationAction() {
        $thing_1 = new Varien_Object ();
        $thing_1-> setName ('Richard');
        $thing_1-> setAge (24);

        $thing_2 = new Varien_Object ();
        $thing_2-> setName ('Jane');
        $thing_2-> setAge (12);

        $thing_3 = new Varien_Object ();
        $thing_3-> setName ('Spot');
        $thing_3-> setLastName ('O Cachorro');
        $thing_3-> setAge (7);
        echo 'done ';
    }
    public function indexAction() {
        echo 'Hello Index!';
    }

}

