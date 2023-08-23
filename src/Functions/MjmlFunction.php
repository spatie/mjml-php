<?php

namespace Spatie\Mjml\Functions;

use Hammerstone\Sidecar\LambdaFunction;
use Hammerstone\Sidecar\Package;
use Hammerstone\Sidecar\Runtime;
use Hammerstone\Sidecar\WarmingConfig;

class MjmlFunction extends LambdaFunction
{
    public function __construct(
        protected int $memory = 2048,
        protected int $warmingInstances = 0,
    ) {
    }

    public function handler(): string
    {
        return 'sidecar.handle';
    }

    public function name(): string
    {
        return 'Mjml';
    }

    public function package(): Package
    {
        return Package::make()
            ->setBasePath(__DIR__ . '/../../lambda')
            ->include('*');
    }

    public function runtime(): string
    {
        return Runtime::NODEJS_16;
    }

    public function memory(): int
    {
        return $this->memory;
    }

    public function warmingConfig(): WarmingConfig
    {
        return WarmingConfig::instances($this->warmingInstances);
    }
}
