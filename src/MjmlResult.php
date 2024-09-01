<?php

namespace Spatie\Mjml;

class MjmlResult
{
    public function __construct(
        protected array $rawResult
    ) {}

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

    /** @return array<MjmlError> */
    public function errors(): array
    {
        return array_map(function (array $errorProperties) {
            return new MjmlError($errorProperties);
        }, $this->rawResult['errors'] ?? []);
    }

    public function hasErrors(): bool
    {
        return count($this->errors()) > 0;
    }
}
