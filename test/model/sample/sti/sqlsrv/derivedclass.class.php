<?php
namespace sample\sti\sqlsrv;
use xPDO\xPDO;

class derivedClass extends \sample\sti\derivedClass
{
    use \sample\sti\sqlsrv\baseClass;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '3.0',
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
