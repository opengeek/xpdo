<?php
namespace sample\sti\sqlsrv;
use xPDO\xPDO;

class derivedClass2 extends \sample\sti\derivedClass2
{
    use \sample\sti\sqlsrv\derivedClass;
    public static function map(xPDO &$xpdo) {
        $xpdo->map[__CLASS__] = array (
            'package' => 'sample\\sti',
            'version' => '3.0',
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
