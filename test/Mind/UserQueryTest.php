<?php

use PHPUnit\Framework\TestCase;
use losthost\ReflexA\Mind\UserQuery;
use losthost\ReflexA\ReflexA;

class UserQueryTest extends TestCase {
    
    public function testQuery() {
        
        $reflexa = new ReflexA(0);
       
        $filter = new UserQuery(0);
        $response = $filter->query(<<<FIN
                Привет! Я Вася, а ты кто?
                FIN, 0.1);
        
        $result = $response->choices[0]->message->content;
        $this->assertEquals('', $result);
    }
        
}
