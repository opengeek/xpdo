<?php
namespace sample\sti\mysql;
use xPDO\xPDO;

class derivedClass extends \sample\sti\derivedClass {
    use \xPDO\om\mysql\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        parent::map($xpdo);
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '1.1',
            'extends' => '\\sample\\sti\\baseClass',
            'fields' =>
            array (
                'class_key' => 'sample\\sti\\derivedClass',
            ),
            'fieldMeta' =>
            array (
                'class_key' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => 'sample\\sti\\derivedClass',
                ),
            ),
        );
    }
}