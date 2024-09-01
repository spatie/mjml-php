<?php

namespace Spatie\Mjml;

class MjmlError
{
    public function __construct(protected array $rawError) {}

    public function line(): int
    {
        return $this->rawError['line'] ?? 0;
    }

    public function message(): string
    {
        return $this->rawError['message'] ?? '';
    }

    public function tagName(): string
    {
        return $this->rawError['tagName'] ?? '';
    }

    public function formattedMessage(): string
    {
        return "Line {$this->line()}: {$this->message()}";
    }

    public function __toString(): string
    {
        return $this->formattedMessage();
    }

    public function toArray(): array
    {
        return $this->rawError;
    }
}
