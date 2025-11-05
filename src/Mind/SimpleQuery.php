<?php

namespace losthost\ReflexA\Mind;

use DeepSeek\DeepSeekClient;

class SimpleQuery extends AbstractQuery {
    
    protected function __query(string|array $query): false|string {
        if (!is_string($query)) {
            throw new \Exception('For a simple query parameter $query must be a string');
        }
        $response = DeepSeekClient::build($this->getConfig('api_key'))
                ->query($query)
                ->run();
        return $response;
    }
}
