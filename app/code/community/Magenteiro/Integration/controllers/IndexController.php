<?php
class Magenteiro_Integration_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $model = Mage::getModel('magenteiro_integration/queue');
        $model->load(1);
        echo get_class($model);
    }

    public function insertAction()
    {
        $model = Mage::getModel('magenteiro_integration/queue');
        $model->setEvent('teste');
        $model->setIntegrationType('log');
        $model->setContent('hello');
        $model->save();
        echo "salvou";
    }

    public function editAction()
    {
        $model = Mage::getModel('magenteiro_integration/queue');
        $model->load(1);
        $model->setContent('world');
        $model->save();
        echo 'editou';
    }

    public function deleteAction()
    {
        $model = Mage::getModel('magenteiro_integration/queue');
        $model->load(1);
        $model->delete();
        echo 'apagou';
    }

    public function showLogsAction()
    {
        /** @var Magenteiro_Integration_Model_Resource_Queue_Collection $logs */
        $logs = Mage::getModel('magenteiro_integration/queue')->getCollection();

        foreach ($logs as $logEntry)
        {
            echo '<h2>' . $logEntry->getContent() . '</h2>';
        }
    }
}