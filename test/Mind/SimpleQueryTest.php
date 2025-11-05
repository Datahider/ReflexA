<?php

use PHPUnit\Framework\TestCase;

use losthost\ReflexA\Mind\SimpleQuery;

class SimpleQueryTest extends TestCase {
    
    public function testSimpleQuery() : void {
        $simple_query = new SimpleQuery('test');
        $response = $simple_query->query('Как тебя зовут?');
        $this->assertIsString($response);
        error_log($response);
    }
}
