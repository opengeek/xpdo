<?php
namespace sample\sqlite;
use xPDO\xPDO;

class BloodType extends \sample\BloodType {
    use \xPDO\om\sqlite\xPDOObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample',
            'version' => '1.1',
            'table' => 'blood_types',
            'extends' => '\\xPDO\\om\\xPDOObject',
            'fields' =>
            array (
                'type' => NULL,
                'description' => NULL,
            ),
            'fieldMeta' =>
            array (
                'type' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '100',
                    'phptype' => 'string',
                    'null' => false,
                    'index' => 'pk',
                ),
                'description' =>
                array (
                    'dbtype' => 'text',
                    'phptype' => 'string',
                    'null' => true,
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
                        'type' =>
                        array (
                            'collation' => 'A',
                            'null' => false,
                        ),
                    ),
                ),
            ),
            'aggregates' =>
            array (
                'Person' =>
                array (
                    'class' => 'sample\\Person',
                    'local' => 'type',
                    'foreign' => 'blood_type',
                    'cardinality' => 'many',
                    'owner' => 'foreign',
                ),
            ),
        );
    }
}