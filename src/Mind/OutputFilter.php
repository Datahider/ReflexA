<?php

namespace losthost\ReflexA\Mind;

use losthost\ReflexA\ReflexA;

class OutputFilter extends AbstractUserQuery {
    
    protected function agentName(): string {
        return 'OutputFilter';
    }

    protected function makeContext(): array {
        $settings = ReflexA::getConfig($this->agentName());
        $context[] = ['role' => 'system', 'content' => $settings->prompt];
        return $context;
    }

    protected function postProcess(\stdClass $response): void {
        
    }
}
