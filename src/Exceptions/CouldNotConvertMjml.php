<?php

namespace Spatie\Mjml\Exceptions;

use Exception;

class CouldNotConvertMjml extends Exception
{
    public static function make(string $reason): self
    {
        return new static($reason);
    }
}
