<?php

namespace losthost\ReflexA\Data;

use losthost\DB\DBObject;

class UserData extends DBObject {
    
    const METADATA = [
        'id' => 'BIGINT NOT NULL',
        'prompt_id' => 'BIGINT',
        'context_start' => 'DATETIME'
    ];
}
