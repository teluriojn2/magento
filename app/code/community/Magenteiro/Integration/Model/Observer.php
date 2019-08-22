<?php
class Magenteiro_Integration_Model_Observer
{
    public function execute(Varien_Event_Observer $observer)
    {
        $model = Mage::getModel('magenteiro_integration/queue');
        $content = $observer->getOrder()->debug();
        $model->setData(array(
            'event'=> 'sales_order_place_after',
            'content' => serialize($content),
            'integration_type' => 'order'
        ));
        $model->save();
    }
}