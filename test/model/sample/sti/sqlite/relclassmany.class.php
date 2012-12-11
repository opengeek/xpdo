<?php
namespace sample\sti\sqlite;
use xPDO\xPDO;
class relClassMany extends \sample\sti\relClassMany
{
    use \xPDO\om\sqlite\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '3.0',
            'table' => 'sti_related_many',
            'extends' => '\\xPDO\\om\\xPDOSimpleObject',
            'fields' => 
            array (
                'field1' => NULL,
                'field2' => NULL,
                'date_modified' => 'CURRENT_TIMESTAMP',
                'fkey' => NULL,
            ),
            'fieldMeta' => 
            array (
                'field1' => 
                array (
                    'dbtype' => 'varchar',
                    'precision' => '200',
                    'phptype' => 'string',
                    'null' => false,
                ),
                'field2' => 
                array (
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'phptype' => 'boolean',
                    'null' => false,
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
            ),
            'indexes' => 
            array (
                'fkey2' => 
                array (
                    'alias' => 'fkey2',
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
            'aggregates' => 
            array (
                'relParent' => 
                array (
                    'class' => 'sample\\sti\\baseClass',
                    'local' => 'fkey',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ),
            ),
        );
    }
}
