<?php

use losthost\ReflexA\ReflexA;

require 'vendor/autoload.php';
ReflexA::initDB();


echo '> ';

$reflexa = new \losthost\ReflexA\ReflexA(0);

while ($s = readline()) {
    $answer = $reflexa->query($s);
    echo <<<FIN
        $answer
        
        > 
        FIN;
}
