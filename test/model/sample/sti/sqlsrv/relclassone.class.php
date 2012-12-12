<?php
namespace sample\sti\sqlsrv;
use xPDO\xPDO;

class relClassOne extends \sample\sti\relClassOne
{
    use \xPDO\om\sqlsrv\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '3.0',
            'table' => 'sti_related_one',
            'extends' => '\\xPDO\\om\\xPDOSimpleObject',
            'fields' => 
            array (
                'field1' => NULL,
                'field2' => NULL,
            ),
            'fieldMeta' => 
            array (
                'field1' => 
                array (
                    'dbtype' => 'int',
                    'precision' => '11',
                    'phptype' => 'integer',
                    'null' => false,
                ),
                'field2' => 
                array (
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                ),
            ),
            'aggregates' => 
            array (
                'relParent' => 
                array (
                    'class' => 'sample\\sti\\baseClass',
                    'local' => 'id',
                    'foreign' => 'fkey',
                    'cardinality' => 'one',
                    'owner' => 'local',
                ),
            ),
        );
    }
}
