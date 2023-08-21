<?php

namespace Spatie\Mjml;

enum ValidationLevel: string
{
    case Strict = 'strict';
    case Soft = 'soft';
    case Skip = 'skip';
}
