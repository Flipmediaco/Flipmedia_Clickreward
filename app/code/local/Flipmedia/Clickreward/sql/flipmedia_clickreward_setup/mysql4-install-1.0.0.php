<?php
$installer = $this;
$installer->startSetup();

try
{
    $installer->run("

CREATE TABLE IF NOT EXISTS `{$installer->getTable('fm_clickreward_rule')}` (
 `id` int(11) unsigned NOT NULL auto_increment,
 `is_active` tinyint(1) NOT NULL default '0',
 `store_id` int(2) NOT NULL,
 `rule_name` varchar(255) NOT NULL,
 `rule_desc` varchar(255) NOT NULL,
 `rule_token` varchar(255) UNIQUE NOT NULL,
 `rule_from_date` date,
 `rule_to_date` date,
 `point_amount` int(11) unsigned NOT NULL default '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('fm_clickreward_rule_track')}` (
 `id` int(11) unsigned NOT NULL auto_increment,
 `rule_id` int(11) unsigned NOT NULL default '0',
 `customer_id` int(11) unsigned NOT NULL default '0',
 `point_amount` int(11) unsigned NOT NULL default '0',
 PRIMARY KEY (`id`),
 KEY `rule_id` (`rule_id`),
 KEY `customer_id` (`customer_id`),
 CONSTRAINT `FK_rule_track` FOREIGN KEY (`rule_id`) REFERENCES `{$installer->getTable('fm_clickreward_rule')}` (`id`) ON DELETE CASCADE,
 CONSTRAINT `FK_customer` FOREIGN KEY (`customer_id`) REFERENCES `{$installer->getTable('customer_entity')}` (`entity_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

} catch(Exception $e) { 
	Mage::logException($e);
}

$installer->endSetup();
