<?php

namespace losthost\ReflexA\Mind;

use losthost\ReflexA\Data\UserAgentData;
use losthost\ReflexA\Data\Prompt;
use losthost\ReflexA\ReflexA;
use losthost\ReflexA\Types\ErrorDescription;
use losthost\ReflexA\Data\Context;
use losthost\DB\DBView;

abstract class AbstractUserQuery {
    
    const ERR_EMPTY_RESPONSE = -11001;

    protected string $user_id;
    protected string $agent_name;
    protected UserAgentData $user_agent_data;
    protected ?ErrorDescription $last_error;
    protected ComplexQuery $api;

    public function __construct(string $user_id, string $agent_name) {
        $this->user_id = $user_id;
        $this->agent_name = $agent_name;
        
        $this->user_agent_data = UserAgentData::getByUserAgent($user_id, $agent_name);
        if ($this->user_agent_data->isNew()) {
            
            $prompt = new Prompt();
            $prompt->prompt = ReflexA::getConfig($agent_name, 'prompt');
            $prompt->date_time = date_create();
            $prompt->write();
            
            $this->user_agent_data->prompt_id = $prompt->id;
            $this->user_agent_data->write();
        }
        
        $this->api = new ComplexQuery($this->agent_name);
    }
    
    public function hasError() : bool {
        return !empty($this->last_error);
    }
    
    public function getLastError() : ErrorDescription {
        return $this->last_error;
    }

    protected function getContext() {

        $prompt = new Prompt(['id' => $this->user_agent_data->prompt_id]);
        
        $context = [
            ['role' => 'system', 'content' => $prompt->prompt]
        ];

        $context_view = new DBView("SELECT role, content, date_time FROM [rxContext] WHERE user=? AND agent = ? AND date_time >= ? ORDER BY date_time", [$this->user_id, $this->agent_name, $this->user_agent_data->context_start]);
        while ($context_view->next()) {
            $context[] = ['role' => $context_view->role, 'content' => $context_view->content];
        }
        
        return $context;
    
    }
    
    protected function addContext(string $content, string $role='user') : Context {
        return Context::add($this->user_id, $this->agent_name, $role, $content);
    }
    
    public function query(string $query) : false|string {
        $this->addContext($query);
        $context = $this->getContext($query);
        
        $response_json = $this->api->query($context);

        try {
            $answer = $this->getResponseContent($response_json);
            Context::add($this->user_id, $this->agent_name, 'assistant', $answer);
            return $answer;
        } catch (\Exception $e) {
            $this->last_error = new ErrorDescription($e->getMessage(), $e->getTraceAsString(), $e->getCode());
            return false;
        }
    }
    
    protected function getResponseContent(string $response_json) : string {
        if (!$response_json) {
            $err = $this->api->getLastError();
            throw new \Exception($err->getMessage(), $err->getCode());
        } 
        
        $response = json_decode($response_json);
        return $response->choices[0]->message->content;
    }
}
