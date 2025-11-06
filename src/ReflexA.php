<?php

namespace losthost\ReflexA;

use losthost\DB\DB;
use losthost\ReflexA\Data\Context;
use losthost\ReflexA\Data\Prompt;
use losthost\ReflexA\Data\UserData;

class ReflexA {

    public function __construct() {
        $this->initDB();
    }
    
    protected function initDB() {
        $db = static::getConfig('db');
        DB::connect($db->host, $db->user, $db->pass, $db->name, $db->prefix);
        Context::initDataStructure();
        Prompt::initDataStructure();
        UserData::initDataStructure();
    }
    
    static public function getConfig(string $section, ?string $param_name=null) : mixed {
        require 'etc/reflexa_conf.php';
        if (is_null($param_name)) {
            return (object)$reflexa_conf[$section];
        }
        return $reflexa_conf[$section][$param_name];
    }
    
}
