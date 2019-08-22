<?php
class Magenteiro_Primeirobloco_Block_Hello extends Mage_Core_Block_Template
{
    public function getHello()
    {
        if(!Mage::getStoreConfigFlag('configs/visual/habilitado'))
            return '';

        return "Hello " . Mage::getStoreConfig('configs/visual/palavra');
    }
}