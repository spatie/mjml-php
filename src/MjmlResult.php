<?php

namespace Spatie\Mjml;

class MjmlResult
{
    public function __construct(
        protected array $rawResult
    ){}

    public function html(): string
    {
        return $this->rawResult['html'] ?? '';
    }

    public function array(): array
    {
        return $this->rawResult['json'] ?? [];
    }

    public function raw(): array
    {
        return $this->rawResult;
    }

    public function errors(): array
    {
        return $this->rawResult['errors'] ?? [];
    }

    public function hasErrors(): bool
    {
        return count($this->errors()) > 0;
    }
}
