<?php

namespace Spatie\Mjml\Tests;

use Hammerstone\Sidecar\Deployment;
use Hammerstone\Sidecar\Providers\SidecarServiceProvider;
use Orchestra\Testbench\Bootstrap\LoadEnvironmentVariables;
use Spatie\Mjml\Functions\MjmlFunction;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SidecarServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        config()->set('sidecar.functions', [MjmlFunction::class]);
        config()->set('sidecar.env', 'testing');
        config()->set('sidecar.aws_key', env('SIDECAR_ACCESS_KEY_ID'));
        config()->set('sidecar.aws_secret', env('SIDECAR_SECRET_ACCESS_KEY'));
        config()->set('sidecar.aws_region', 'eu-central-1');
        config()->set('sidecar.aws_bucket', 'sidecar-mjml');
        config()->set('sidecar.execution_role', env('SIDECAR_EXECUTION_ROLE'));

        Deployment::make()->deploy()->activate();
    }
}
