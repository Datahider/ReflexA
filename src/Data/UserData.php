<?php

namespace losthost\ReflexA\Data;

use losthost\DB\DBObject;

class UserData extends DBObject {
    
    const METADATA = [
        'id' => 'BIGINT NOT NULL',
        'prompt_id' => 'BIGINT NOT NULL',
        'context_start_id' => 'BIGINT NOT NULL'
    ];
}
