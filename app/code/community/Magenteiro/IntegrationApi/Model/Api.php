<?php
class Magenteiro_IntegrationApi_Model_Api extends Mage_Api_Model_Resource_Abstract
{
    public function listIntegrations($filter=false)
    {
//        return "hello world";
        $this->_fault('empty_search', 'Falhou');
    }
}