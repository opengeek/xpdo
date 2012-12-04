<?php
namespace sample\sti\mysql;
use xPDO\xPDO;

class relClassMany extends \sample\sti\relClassMany {
    use \xPDO\om\mysql\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        parent::map($xpdo);
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '1.1',
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
                    'attributes' => 'ON UPDATE CURRENT_TIMESTAMP',
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
                'fkey' =>
                array (
                    'alias' => 'fkey',
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
