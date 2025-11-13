<?php

namespace losthost\ReflexA\Data;

use losthost\DB\DBObject;
use losthost\DB\DB;

class UserData extends DBObject {
    
    const METADATA = [
        'id' => 'VARCHAR(50) NOT NULL',
        'prompt_id' => 'BIGINT',
        'context_start' => 'DATETIME',
        'PRIMARY KEY' => 'id'
    ];

    public static function tableName() {
        return DB::$prefix. 'rxUserData';
    }
    
}
