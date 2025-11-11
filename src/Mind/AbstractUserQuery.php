<?php

namespace losthost\ReflexA\Mind;

abstract class AbstractUserQuery {
    
    protected int $user_id;
    
    abstract protected function agentName() : string;
    abstract protected function makeContext() : array;
    abstract protected function postProcess(\stdClass $response) : void;

    public function __construct(int $user_id) {
        $this->user_id = $user_id;
    }
    
    public function query(string $query) {
        $context = $this->makeContext();
        $context[] = ['role' => 'user', 'content' => $query];
        
        $api = new ComplexQuery($this->agentName());
        $response_json = $api->query($context);
        
        if ($response_json) {
            $response = json_decode($response_json);
            $this->postProcess($response);
        } else {
            $response = (object)[
                'error' => true,
                'description' => $api->getLastError()
            ];
        }
        
        return $response;
    }
}
