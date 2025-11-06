<?php

namespace losthost\ReflexA\Data;

use losthost\DB\DBObject;

class Context extends DBObject {
    
    const METADATA = [
        'id' => 'BIGINT NOT NULL AUTO_INCREMENT',
        'user' => 'BIGINT NOT NULL',
        'role' => 'ENUM("user", "assistant")',
        'content' => 'TEXT',
        'date_time' => 'DATETIME NOT NULL',
        'PRIMARY KEY' => 'id'
    ];
    
}
