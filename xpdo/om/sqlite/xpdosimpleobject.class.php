<?php
namespace xPDO\om\sqlite;

use xPDO\xPDO;

/**
 * A trait defining xPDOSimpleObject property and method overrides for SQLite.
 *
 * @package xpdo
 * @subpackage om.sqlite
 */
trait xPDOSimpleObject {
    /**
     * Register the map for this class in an xPDO instance.
     *
     * @param \xPDO\xPDO $xpdo
     */
    public static function map(xPDO &$xpdo) {
        $xpdo->map['xPDO\\om\\xPDOSimpleObject'] = $xpdo->map[__CLASS__] = array (
            'table' => null,
            'fields' => array (
                'id' => null,
            ),
            'fieldMeta' => array (
                'id' => array(
                    'dbtype' => 'INTEGER',
                    'phptype' => 'integer',
                    'null' => false,
                    'index' => 'pk',
                    'generated' => 'native',
                )
            ),
            'indexes' => array (
                'PRIMARY' => array (
                    'columns' => array(
                        'id' => array()
                    ),
                    'primary' => true,
                    'unique' => true
                )
            )
        );
    }
}
