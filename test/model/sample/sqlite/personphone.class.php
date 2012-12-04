<?php
namespace sample\sqlite;
use xPDO\xPDO;

class PersonPhone extends \sample\PersonPhone {
    use \xPDO\om\sqlite\xPDOObject;
    public static function map(xPDO &$xpdo) {
        parent::map($xpdo);
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample',
            'version' => '1.1',
            'table' => 'person_phone',
            'extends' => '\\xPDO\\om\\xPDOObject',
            'fields' =>
            array (
                'person' => NULL,
                'phone' => NULL,
                'is_primary' => 0,
            ),
            'fieldMeta' =>
            array (
                'person' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '11',
                    'phptype' => 'integer',
                    'null' => false,
                    'index' => 'pk',
                ),
                'phone' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '11',
                    'phptype' => 'integer',
                    'null' => false,
                    'index' => 'pk',
                ),
                'is_primary' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '1',
                    'phptype' => 'boolean',
                    'null' => false,
                    'default' => 0,
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
                        'person' =>
                        array (
                            'collation' => 'A',
                            'null' => false,
                        ),
                        'phone' =>
                        array (
                            'collation' => 'A',
                            'null' => false,
                        ),
                    ),
                ),
            ),
            'composites' =>
            array (
                'Phone' =>
                array (
                    'class' => 'sample\\Phone',
                    'local' => 'phone',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ),
            ),
            'aggregates' =>
            array (
                'Person' =>
                array (
                    'class' => 'sample\\Person',
                    'local' => 'person',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ),
            ),
        );
    }
}
