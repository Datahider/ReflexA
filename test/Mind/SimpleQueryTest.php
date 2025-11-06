<?php

use PHPUnit\Framework\TestCase;

use losthost\ReflexA\Mind\SimpleQuery;

class SimpleQueryTest extends TestCase {
    
    public function testSimpleQuery() : void {
        $simple_query = new SimpleQuery('test');
        $response = json_decode($simple_query->query('Как тебя зовут?'));
        $this->assertStringContainsString('DeepSeek', $response->choices[0]->message->content);
    }
}
