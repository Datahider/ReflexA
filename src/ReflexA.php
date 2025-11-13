<?php

namespace losthost\ReflexA;

use losthost\DB\DB;
use losthost\ReflexA\Data\Context;
use losthost\ReflexA\Data\Prompt;
use losthost\ReflexA\Data\UserData;

use losthost\ReflexA\Mind\InputFilter;
use losthost\ReflexA\Mind\UserQuery;
use losthost\ReflexA\Mind\OutputFilter;

class ReflexA {

    protected string $user_id;
    
    public function __construct(string $user_id) {
        $this->user_id = $user_id;
    }
    
    public function query(string $query) : string {
        
        $now = date_create();
        
        $user_data = new UserData(['id' => $this->user_id], true);
        if ($user_data->context_start === null) {
            $user_data->context_start = $now;
            $user_data->write();
        }
        
        $context_item_user = new Context();
        $context_item_user->user = $this->user_id;
        $context_item_user->role = 'user';
        $context_item_user->content = $query;
        $context_item_user->date_time = $now;

        $ifilter = new InputFilter($this->user_id);
        $ifilter_response = $ifilter->query($query);
        $risk_score = (float) $ifilter_response->choices[0]->message->content;
        $metadata = ['risk_score' => $risk_score];
        
        $main = new UserQuery($this->user_id);
        
        while (true) {
            $main_response = $main->query($query, $metadata);
            if (isset($main_response->error)) {
                $answer = "Ошибка генерации:\n$main_response->message\n$main_response->description";
                break;
            } else {
                $answer = $main_response->choices[0]->message->content;

                $ofilter = new OutputFilter($this->user_id);
                $ofilter_response = $ofilter->query(<<<FIN
                        ## ПОЛЬЗОВАТЕЛЬ:
                        $query

                        ## НИКА:
                        $answer
                        FIN);

                $ofilter_result = $ofilter_response->choices[0]->message->content;
                $m = [];
                if (preg_match("/^\[OK\]/", $ofilter_result)) {
                    break;
                } elseif (preg_match("/^\[ERROR\]\s(.*)/", $ofilter_result, $m)) {
                    $metadata['error'] = $m[1];
                    error_log($ofilter_result);
                } else {
                    $answer = $ofilter_result;
                    error_log($ofilter_result);
                    break;
                }
            }

            error_log($answer);
            
        }
        
        $context_item_assistant = new Context();
        $context_item_assistant->user = $this->user_id;
        $context_item_assistant->role = 'assistant';
        $context_item_assistant->content = $answer;
        $context_item_assistant->date_time = date_create();
      
        $context_item_user->write();
        $context_item_assistant->write();
        
        return $answer;
    }
    
    static public function initDB() {
        $db = static::getConfig('db');
        DB::connect($db->host, $db->user, $db->pass, $db->name, $db->prefix);
        Context::initDataStructure();
        Prompt::initDataStructure();
        UserData::initDataStructure();
    }
    
    static public function getConfig(string $section, ?string $param_name=null) : mixed {
        require 'etc/reflexa_conf.php';
        if (is_null($param_name)) {
            return (object)$reflexa_conf[$section];
        }
        return $reflexa_conf[$section][$param_name];
    }
    
}
