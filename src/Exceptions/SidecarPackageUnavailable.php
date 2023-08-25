<?php

namespace Spatie\Mjml\Exceptions;

use Exception;

class SidecarPackageUnavailable extends Exception
{
    public static function make(): self
    {
        return new static('You must install the spatie/mjml-sidecar package to convert MJML to html using Sidecar');
    }
}
