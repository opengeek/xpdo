<?php
namespace sample\sqlsrv;
use xPDO\xPDO;

/**
 * Represents a one to many relationship between a Person and a Phone.
 *
 * @package sample.sqlsrv
 */
class PersonPhone extends \sample\PersonPhone
{
    use \xPDO\om\sqlsrv\xPDOObject;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample',
            'version' => '3.0',
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
