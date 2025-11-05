<?php

namespace losthost\ReflexA\Mind;

use DeepSeek\DeepSeekClient;

class ComplexQuery extends AbstractQuery {
    
    protected function __query(string|array $query): false|string {
        if (!is_array($query)) {
            throw new \Exception('For a complex query $query must be an array.');
        }
        
        $api = DeepSeekClient::build($this->getConfig('api_key'));
        
        foreach ($query as $index => $message) {
            if (empty($message['role']) || empty($message['text'])) {
                throw new \Exception("Wrong context format ($index). Must contain 'role' and 'text'.");
            }
            $api->query($message['text'], $message['role']);
        }
        
        $response = $api->run();
        return $response;
    }
}
