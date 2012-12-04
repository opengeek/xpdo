<?php
$xpdo_meta_map = array (
    'xPDO\\om\\xPDOSimpleObject' =>
    array (
        0 => 'sample\\sti\\baseClass',
        1 => 'sample\\sti\\relClassOne',
        2 => 'sample\\sti\\relClassMany',
    ),
    'xPDO\\om\\mysql\\xPDOSimpleObject' =>
    array (
        0 => 'sample\\sti\\mysql\\baseClass',
        1 => 'sample\\sti\\mysql\\relClassOne',
        2 => 'sample\\sti\\mysql\\relClassMany',
    ),
    'sample\\sti\\baseClass' =>
    array (
        0 => 'sample\\sti\\mysql\\derivedClass',
        1 => 'sample\\sti\\derivedClass',
    ),
    'sample\\sti\\derivedClass' =>
    array (
        0 => 'sample\\sti\\mysql\\derivedClass',
        1 => 'sample\\sti\\derivedClass2',
    ),
    'sample\\sti\\derivedClass2' =>
    array (
        0 => 'sample\\sti\\mysql\\derivedClass2',
    ),
    'sample\\sti\\relClassOne' =>
    array (
        0 => 'sample\\sti\\mysql\\relClassOne',
    ),
    'sample\\sti\\relClassMany' =>
    array (
        0 => 'sample\\sti\\mysql\\relClassMany',
    ),
);