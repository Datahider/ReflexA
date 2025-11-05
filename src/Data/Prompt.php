<?php

namespace losthost\ReflexA\Data;

class Prompt {
    
    const METADATA = [
        'id' => 'BIGINT NOT NULL AUTO_INCREMENT',
        'user' => 'BIGINT NOT NULL',
        'prompt' => 'TEXT',
        'date_time' => 'DATETIME NOT NULL',
        'PRIMARY KEY' => 'id'
    ];
}
