<?php

use losthost\ReflexA\ReflexA;
use losthost\ReflexA\Mind\SimpleAgent;

require 'vendor/autoload.php';
ReflexA::initDB();


echo '> ';

$agent = new SimpleAgent(0, 'main');

while ($s = readline()) {
    $answer = $agent->query($s);
    
    if (!$agent->hasError()) {
        echo <<<FIN
            $answer

            > 
            FIN;
    } else {
        echo 'Error: '. $agent->getLastError()->getMessage();
    }
}
