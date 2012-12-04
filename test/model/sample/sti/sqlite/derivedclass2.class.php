<?php
namespace sample\sti\sqlite;
use xPDO\xPDO;

class derivedClass2 extends \sample\sti\derivedClass2 {
    use \xPDO\om\sqlite\xPDOSimpleObject;
    public static function map(xPDO &$xpdo) {
        parent::map($xpdo);
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '1.1',
            'extends' => '\\sample\\sti\\derivedClass',
            'fields' =>
            array (
                'class_key' => 'sample\\sti\\derivedClass2',
                'field3' => '',
            ),
            'fieldMeta' =>
            array (
                'class_key' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => 'sample\\sti\\derivedClass2',
                ),
                'field3' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '32',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            ),
        );
    }
}