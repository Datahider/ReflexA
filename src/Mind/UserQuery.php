<?php

namespace losthost\ReflexA\Mind;

use losthost\DB\DBValue;
use losthost\DB\DBView;
use losthost\ReflexA\Data\UserData;
use losthost\ReflexA\Data\Prompt;
use losthost\ReflexA\ReflexA;

class UserQuery extends AbstractUserQuery {
   
    
    protected function agentName(): string {
        return 'main';
    }

    public function query(string $query, array $metadata=[]) {
        
        $metadata_block = '';
        foreach ($metadata as $key=>$value) {
            $metadata_block .= "> $key: $value\n";
        }
        
        error_log($metadata_block);
        
        $metadata_added = <<<FIN
                $query

                $metadata_block
                FIN;
        return parent::query($metadata_added);
    }
    
    protected function makeContext(): array {
        $user_data = new UserData(['id' => $this->user_id], true);

        if ($user_data->prompt_id) {
            $prompt = new Prompt(['id' => $user_data->prompt_id, 'user' => $this->user_id]);
        } else {
            $prompt = new Prompt();
            $prompt->user = $this->user_id;
            $prompt->prompt = ReflexA::getConfig($this->agentName(), 'prompt');
            $prompt->date_time = date_create();
            $prompt->write();
            $user_data->prompt_id = $prompt->id;
            $user_data->write();
        }
        
        $context_view = new DBView("SELECT role, content, date_time FROM [Context] WHERE user=? AND date_time >= ? ORDER BY date_time", [$this->user_id, $user_data->context_start]);
        
        $context = [
            ['role' => 'system', 'content' => $prompt->prompt]
        ];
        while ($context_view->next()) {
            $context[] = ['role' => $context_view->role, 'content' => $context_view->content];
        }
        
        return $context;
    }

    protected function postProcess(\stdClass $response): void {
        
    }
}
