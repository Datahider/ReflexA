<?php

namespace losthost\ReflexA\Data;

use losthost\DB\DBObject;
use losthost\DB\DB;

class UserAgentData extends DBObject {
    
    const METADATA = [
        'id' => 'BIGINT NOT NULL AUTO_INCREMENT',
        'user' => 'VARCHAR(50) NOT NULL',
        'agent' => 'VARCHAR(50) NOT NULL',
        'prompt_id' => 'BIGINT',
        'context_start' => 'DATETIME',
        'PRIMARY KEY' => 'id',
        'UNIQUE INDEX USER_AGENT' => ['user', 'agent']
    ];
    
    public static function tableName() {
        return DB::$prefix. 'rxUserAgentData';
    }
    
    static public function getByUserAgent(string $user, string $agent) {
        
        $me = new static(['user' => $user, 'agent' => $agent], true);
        
        if ($me->isNew()) {
            $me->context_start = date_create();
        }
        
        return $me;
    }
    
}
