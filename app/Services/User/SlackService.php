<?php
namespace App\Services\User;

use Illuminate\Support\Facades\Http;

class SlackService
{
    public function send($message)
    {
        Http::post(env('SLACK_WEBHOOK_URL'), [
            'text' => $message
        ]);
    }
}

