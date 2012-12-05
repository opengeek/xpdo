<?php
namespace sample\sqlite;
use xPDO\xPDO;

class Phone extends \sample\Phone {
    use \xPDO\om\sqlite\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample',
            'version' => '1.1',
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
                    'dbtype' => 'timestamp',
                    'phptype' => 'timestamp',
                    'null' => false,
                    'default' => 'CURRENT_TIMESTAMP',
                ),
            ),
            'indexes' =>
            array (
                'PRIMARY' =>
                array (
                    'alias' => 'PRIMARY',
                    'primary' => true,
                    'unique' => true,
                    'columns' =>
                    array (
                        'id' =>
                        array (
                            'collation' => 'A',
                            'null' => false,
                        ),
                    ),
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
