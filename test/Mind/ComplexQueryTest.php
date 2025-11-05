<?php

use PHPUnit\Framework\TestCase;
use losthost\ReflexA\Mind\ComplexQuery;

class ComplexQueryTest extends TestCase {
    
    public function testConstructor() {
        $this->expectExceptionMessage('Awaiting user id as a second parameter.');
        $query = new ComplexQuery('test');
    }
}
