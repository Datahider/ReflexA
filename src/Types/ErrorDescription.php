<?php

namespace losthost\ReflexA\Types;

class ErrorDescription {
    
    protected ?string $message;
    protected ?string $description;
    protected ?int    $code;
    
    public function __construct(string $message, ?string $description=null, ?int $code=null) {
        $this->message = $message;
        $this->description = $description;
        $this->code = $code;
    }
    
    public function getCode() {
        return $this->code;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function getDescription() {
        return $this->description;
    }
}
