<?php

namespace Spatie\Mjml;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class Mjml
{
    public function toHtml(string $mjml): string
    {
        return $this->callMjml($mjml)->html();
    }

    protected function callMjml(string $mjml): MjmlResult
    {
        $arguments = [
            $mjml,
            [
                'name' => 'value',
            ]
        ];

        $command = [
            (new ExecutableFinder())->find('node', 'node', [
                '/usr/local/bin',
                '/opt/homebrew/bin',
            ]),
            'mjml.mjs',
            json_encode(array_values($arguments)),
        ];

        $process = new Process(
            $command,
            $this->getWorkingDirectory(),
            null,
        );

        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $resultString =  $process->getOutput();

        $resultProperties = json_decode($resultString, true);

        return new MjmlResult($resultProperties);
    }

    public function getWorkingDirectory()
    {
        return realpath(dirname(__DIR__) . '/bin');
    }
}
