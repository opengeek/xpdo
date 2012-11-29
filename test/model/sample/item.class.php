<?php
namespace sample;

class Item extends \xPDO\om\xPDOSimpleObject {
    public static function callTest() {
        return 'Item';
    }
}