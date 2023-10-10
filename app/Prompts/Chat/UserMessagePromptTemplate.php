<?php

namespace App\Prompts\Chat;

class UserMessagePromptTemplate
{
    public static function fromString(string $message): array
    {
        return [
            'role' => 'user',
            'content' => $message,
        ];
    }
}
