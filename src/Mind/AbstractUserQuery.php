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
        
        $response = json_decode($api->query($context));
        
        $this->postProcess($response);
        return $response;
    }
}
