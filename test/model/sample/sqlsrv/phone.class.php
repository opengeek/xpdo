<?php
namespace sample\sqlsrv;
use xPDO\xPDO;

/**
 * Represents a Phone number.
 *
 * @package sample.sqlsrv
 */
class Phone extends \sample\Phone
{
    use \xPDO\om\sqlsrv\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample',
            'version' => '3.0',
            'table' => 'phone',
            'extends' => '\\xPDO\\om\\xPDOSimpleObject',
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
                    'dbtype' => 'datetime',
                    'phptype' => 'datetime',
                    'null' => false,
                    'default' => 'CURRENT_TIMESTAMP',
                ),
            ),
            'composites' => 
            array (
                'PersonPhone' => 
                array (
                    'class' => 'sample\\PersonPhone',
                    'local' => 'id',
                    'foreign' => 'phone',
                    'cardinality' => 'many',
                    'owner' => 'local',
                ),
            ),
        );
    }
}
