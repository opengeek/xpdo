<?php
namespace xPDO\om;

use xPDO\xPDO;

/**
 * Extend to define a class with a native integer primary key field named id.
 *
 * @package xpdo
 * @subpackage om
 */
class xPDOSimpleObject extends xPDOObject {
    public static function map(xPDO &$xpdo) {
        $driverClass = '\\xPDO\\om\\' . $xpdo->getOption('dbtype') . '\\xPDOSimpleObject';
        $driverClass::map($xpdo);
    }
}
