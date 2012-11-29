<?php
namespace sample\mysql;
use xPDO\xPDO;

/**
 * Represents a Phone number.
 *
 * @package sample.mysql
 */
class Phone extends \sample\Phone {
    use \xPDO\om\mysql\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample',
            'version' => '1.1',
            'table' => 'phone',
            'extends' => 'xPDOSimpleObject',
            'fields' =>
            array (
                'type' => '',
                'number' => NULL,
                'date_modified' => 'CURRENT_TIMESTAMP',
            ),
            'fieldMeta' =>
            array (
                'type' =>
                array (
                    'dbtype' => 'enum',
                    'precision' => '\'\',\'home\',\'work\',\'mobile\'',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
                'number' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '20',
                    'phptype' => 'string',
                    'null' => false,
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
            'composites' =>
            array (
                'PersonPhone' =>
                array (
                    'class' => 'PersonPhone',
                    'local' => 'id',
                    'foreign' => 'phone',
                    'cardinality' => 'many',
                    'owner' => 'local',
                ),
            ),
        );
    }
}
