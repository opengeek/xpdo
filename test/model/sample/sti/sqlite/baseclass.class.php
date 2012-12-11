<?php
namespace sample\sti\sqlite;
use xPDO\xPDO;
class baseClass extends \sample\sti\baseClass
{
    use \xPDO\om\sqlite\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '3.0',
            'table' => 'sti_objects',
            'extends' => '\\xPDO\\om\\xPDOSimpleObject',
            'inherit' => 'single',
            'fields' => 
            array (
                'field1' => 0,
                'field2' => '',
                'date_modified' => 'CURRENT_TIMESTAMP',
                'fkey' => NULL,
                'class_key' => 'sample\\sti\\baseClass',
            ),
            'fieldMeta' => 
            array (
                'field1' => 
                array (
                    'dbtype' => 'tinyint',
                    'precision' => '2',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ),
                'field2' => 
                array (
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
                'date_modified' => 
                array (
                    'dbtype' => 'timestamp',
                    'phptype' => 'timestamp',
                    'null' => false,
                    'default' => 'CURRENT_TIMESTAMP',
                ),
                'fkey' => 
                array (
                    'dbtype' => 'int',
                    'precision' => '11',
                    'phptype' => 'integer',
                    'null' => true,
                    'index' => 'fk',
                ),
                'class_key' => 
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => 'sample\\sti\\baseClass',
                ),
            ),
            'indexes' => 
            array (
                'fkey1' => 
                array (
                    'alias' => 'fkey1',
                    'primary' => false,
                    'unique' => false,
                    'columns' => 
                    array (
                        'fkey' => 
                        array (
                            'collation' => 'A',
                            'null' => false,
                        ),
                    ),
                ),
            ),
            'composites' => 
            array (
                'relMany' => 
                array (
                    'class' => 'sample\\sti\\relClassMany',
                    'local' => 'id',
                    'foreign' => 'fkey',
                    'cardinality' => 'many',
                    'owner' => 'local',
                ),
            ),
            'aggregates' => 
            array (
                'relOne' => 
                array (
                    'class' => 'sample\\sti\\relClassOne',
                    'local' => 'fkey',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ),
            ),
        );
    }
}
