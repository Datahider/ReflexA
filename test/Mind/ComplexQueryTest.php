<?php

use PHPUnit\Framework\TestCase;
use losthost\ReflexA\Mind\ComplexQuery;

class ComplexQueryTest extends TestCase {
    
    public function testQuery() {
        $query = new ComplexQuery('test');
        
        $messages = [
            ['role' => 'system', 'content' => 'Ты фильтр определяющий смешной анекдот/шутка или нет. Если смешной -- присылаешь смеющийся эмодзи 🤣, а если не смешной, то серьёзный эмодзи 😐. Больше никаких пояснений, знаков и текста. Если я справшиваю почему ты так решил - объясняешь'],
            ['role' => 'user', 'content' => 'Василий Иваныч пошел к Петьке, а того не было дома']
        ];
        
        $response1 = json_decode($query->query($messages));
        
        $this->assertEquals('😐', $response1->choices[0]->message->content);

        $messages[] = ['role' => 'assistant', 'content' => $response1->choices[0]->message->content];
        $messages[] = ['role' => 'user', 'content' => 'Коза сказала козлятам, чтобы они открывали ей дверь только по паролю "Сосите грудь детки". А волк подслушал. Коза ушла, волк подошел и говорит тоненьким голосом: Козлятки, откройте дверь. Козлята: Скажи пароль! Волк: Сосите грудь детки. Козлята: Сосите хуй дядя волк, мы вас в щелку видим!'];
        
        $response2 = json_decode($query->query($messages));
        
        if ( '🤣' != $response2->choices[0]->message->content ) {
            $messages[] = ['role' => 'assistant', 'content' => '$response2->choices[0]->message->content'];
            $messages[] = ['role' => 'user', 'content' => 'Почему ты считаешь последнюю шутку не смешной?'];
            
            $response3 = json_decode($query->query($messages));
            $this->assertEquals('🤣', $response3->choices[0]->message->content);
        } else {
            $this->assertEquals('🤣', $response2->choices[0]->message->content);
        }
    }
    
}
