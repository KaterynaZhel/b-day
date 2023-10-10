<?php

namespace App\Prompts\Chat;

class SystemMessagePromptTemplate
{
    public static function fromString(string $message): array
    {
        return [
            'role' => 'system',
            'content' => $message,
        ];
    }
}
