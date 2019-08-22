<?php
class Telbs_AddCart_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function logToFile()
    {
        Mage::log($msg, Zend_Log::INFO, 'addcart.log', true);
    }
}