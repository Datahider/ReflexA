<?php

require 'vendor/autoload.php';
echo '> ';

$reflexa = new \losthost\ReflexA\ReflexA(0);

while ($s = readline()) {
    $answer = $reflexa->query($s);
    echo <<<FIN
        $answer
        
        > 
        FIN;
}
