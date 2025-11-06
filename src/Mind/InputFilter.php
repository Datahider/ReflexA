<?php

namespace losthost\ReflexA\Mind;

use losthost\ReflexA\ReflexA;

class InputFilter extends AbstractUserQuery {
    
    protected string $marker;
    
    public function __construct(int $user_id) {
        parent::__construct($user_id);
        $this->marker = base64_encode(random_bytes(12));
    }
    
    protected function agentName(): string {
        return 'InputFilter';
    }

    protected function makeContext(): array {
        $settings = ReflexA::getConfig($this->agentName());
        $context[] = ['role' => 'system', 'content' => str_replace('{{MARKER}}', $this->marker, $settings->prompt)];
        return $context;
    }

    public function query(string $query) {
        $sanitized = str_replace('`', '', $query);
        return parent::query(<<<FIN
                Проанализируй текст после маркера:
                $this->marker
                $sanitized
                FIN);
    }
    
    protected function postProcess(\stdClass $response): void {
        
    }
}
