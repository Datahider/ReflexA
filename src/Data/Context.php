<?php

namespace losthost\ReflexA\Data;

use losthost\DB\DBObject;
use losthost\DB\DB;

class Context extends DBObject {
    
    const METADATA = [
        'id' => 'BIGINT NOT NULL AUTO_INCREMENT',
        'user' => 'VARCHAR(50) NOT NULL',
        'agent' => 'VARCHAR(50) NOT NULL',
        'role' => 'ENUM("user", "assistant")',
        'content' => 'TEXT',
        'date_time' => 'DATETIME NOT NULL',
        'PRIMARY KEY' => 'id',
        'INDEX USER_AGENT' => ['user', 'agent']
    ];
    
    public static function tableName() {
        return DB::$prefix. 'rxContext';
    }
    
    static public function add(string $user, string $agent, string $role, string $content) : static {
        
        $me = new Context();
        $me->user = $user;
        $me->agent = $agent;
        $me->role = $role;
        $me->content = $content;
        $me->date_time = date_create();
        $me->write();
        
        return $me;
    }
}
