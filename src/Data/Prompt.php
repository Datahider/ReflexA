<?php

namespace losthost\ReflexA\Data;

use losthost\DB\DBObject;
use losthost\DB\DB;

class Prompt extends DBObject {
    
    const METADATA = [
        'id' => 'BIGINT NOT NULL AUTO_INCREMENT',
        'prompt' => 'TEXT',
        'date_time' => 'DATETIME NOT NULL',
        'PRIMARY KEY' => 'id'
    ];

    public static function tableName() {
        return DB::$prefix. 'rxPrompt';
    }
    
    
}
