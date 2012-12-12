<?php
namespace sample\mysql;
use xPDO\xPDO;
class Item extends \sample\Item
{
    use \xPDO\om\mysql\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample',
            'version' => '3.0',
            'table' => 'items',
            'extends' => '\\xPDO\\om\\xPDOSimpleObject',
            'fields' => 
            array (
                'name' => '',
                'color' => 'green',
                'description' => NULL,
                'date_modified' => 'CURRENT_TIMESTAMP',
            ),
            'fieldMeta' => 
            array (
                'name' => 
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                    'index' => 'fk',
                ),
                'color' => 
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => 'green',
                    'index' => 'fk',
                ),
                'description' => 
                array (
                    'dbtype' => 'text',
                    'phptype' => 'string',
                    'null' => true,
                ),
                'date_modified' => 
                array (
                    'dbtype' => 'timestamp',
                    'phptype' => 'timestamp',
                    'null' => false,
                    'default' => 'CURRENT_TIMESTAMP',
                    'attributes' => 'ON UPDATE CURRENT_TIMESTAMP',
                ),
            ),
        );
    }

    public static function callTest() {
        return __CLASS__;
    }
}
