<?php

use PHPUnit\Framework\TestCase;
use losthost\ReflexA\Mind\UserQuery;
use losthost\ReflexA\ReflexA;

class UserQueryTest extends TestCase {
    
    public function testQuery() {
        
        $reflexa = new ReflexA();
       
        $filter = new UserQuery(0);
        $response = $filter->query(<<<FIN
                Привет! Я Вася, а ты кто?
                FIN);
        
        $result = $response->choices[0]->message->content;
        $this->assertEquals('', $result);
    }
        
}
