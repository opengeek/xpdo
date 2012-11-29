<?php
namespace sample;
use xPDO\xPDO;

class Person extends \xPDO\om\xPDOSimpleObject {
    public $first_name = '';
    public $last_name = '';
    public $middle_name = '';
    public $date_modified = 'CURRENT_TIMESTAMP';
    public $dob = NULL;
    public $gender = '';
    public $blood_type = NULL;
    public $username = NULL;
    public $password = '';
    public $security_level = 1;
}
