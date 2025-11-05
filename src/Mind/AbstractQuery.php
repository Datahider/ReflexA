<?php

namespace losthost\ReflexA\Mind;

use losthost\ReflexA\Types\ErrorDescription;

abstract class AbstractQuery {
    
    protected string $agent_name;
    protected ErrorDescription $last_error;
    
    abstract protected function __query(string|array $query) : false|string;
    
    public function __construct(string $agent_name) {
        $this->agent_name = $agent_name;
    }
    
    public function query(string|array $query) : null|false|string {
        try {
            return $this->__query($query);
        } catch (\Exception $exc) {
            $this->last_error = new ErrorDescription($exc->getMessage(), $exc->getTraceAsString(), $exc->getCode());
            return null;
        }
    }
    
    protected function getConfig(string $param_name) : mixed {
        require 'etc/reflexa_conf.php';
        return $reflexa_conf[$this->agent_name][$param_name];
    }
    
    public function getLastError() : ErrorDescription {
        return $this->last_error;
    }
}
