<?php
namespace sample;

class TransientDerivative extends Transient {
    public static function callTest() {
        return __CLASS__;
    }
}