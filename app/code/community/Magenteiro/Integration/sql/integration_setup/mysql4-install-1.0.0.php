<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('magenteiro_integration/queue');
/*
$sql = "CREATE TABLE {$tableName} (
  `log_id` int(8) NOT NULL AUTO_INCREMENT,
  `event` varchar(100) DEFAULT NULL COMMENT 'Magento Event',
  `integration_type` varchar(100) DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `integrated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `debug_info` text,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Integration Queues'";
$installer->run($sql);
*/

$queueTable = $installer->getConnection()->newTable($tableName)
    ->addColumn('log_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'length' => 8,
        'nullable' => false,
        'primary' => true,
    ), 'Log id')
    ->addColumn('event', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'length' => 100,
        'comment' => 'Magento Event'
    ))
    ->addColumn('integration_type', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'length' => 100,
    ))
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ))
    ->addColumn('integrated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => '0000-00-00 00:00:00',
        'nullable' => true,
    ))
    ->addColumn('debug_info', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->setComment('Integration Queue');


if ($installer->tableExists($tableName)) {
    $installer->getConnection()->dropTable($tableName);
}
$installer->getConnection()->createTable($queueTable);
$installer->endSetup();

