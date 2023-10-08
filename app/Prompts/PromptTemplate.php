<?php

namespace App\Prompts;

use Illuminate\Support\Str;

class PromptTemplate
{
    public function __construct(public string $template)
    {
    }

    public static function create(string $template): PromptTemplate
    {
        return new self($template);
    }

    public function format(array $inputVariables): PromptTemplate
    {
        $this->template = Str::swap($inputVariables, $this->template);

        return $this;
    }

    public function outputParser(string $outputParser): PromptTemplate
    {
        $this->template = Str::squish($this->template . $outputParser);

        return $this;
    }

    public function parse($response): object
    {
        $formatted = str($response)
            ->trim();

        return $formatted;
    }

    public function toString(): string
    {
        $this->template = Str::squish($this->template);

        return $this->template;
    }
}
