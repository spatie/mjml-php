<?php

namespace Spatie\Mjml;

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class Mjml
{
    protected bool $keepComments = true;

    protected bool $ignoreIncludes = false;

    protected bool $beautify = false;

    protected bool $minify = false;

    protected ValidationLevel $validationLevel;

    protected string $filePath = '.';

    protected string $workingDirectory;

    public static function new(): self
    {
        return new static();
    }

    public function __construct()
    {
        $this->validationLevel = ValidationLevel::Soft;

        $this->workingDirectory = realpath(dirname(__DIR__).'/bin');
    }

    public static function isMjml(string $content): bool
    {
        return (new self)->convert($content)->hasErrors();
    }

    public function keepComments(bool $keepComments = true): self
    {
        $this->keepComments = $keepComments;

        return $this;
    }

    public function hideComments(): self
    {
        return $this->keepComments(false);
    }

    public function ignoreIncludes(bool $ignoreIncludes = true): self
    {
        $this->ignoreIncludes = $ignoreIncludes;

        return $this;
    }

    public function beautify(bool $beautify = true): self
    {
        $this->beautify = $beautify;

        return $this;
    }

    public function minify(bool $minify = true): self
    {
        $this->minify = $minify;

        return $this;
    }

    public function validationLevel(ValidationLevel $validationLevel): self
    {
        $this->validationLevel = $validationLevel;

        return $this;
    }

    public function filePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function workingDirectory(string $workingDirectory): self
    {
        $this->workingDirectory = $workingDirectory;

        return $this;
    }

    public function convert(string $mjml, array $options = []): MjmlResult
    {
        return $this->callMjml($mjml, $options);
    }

    public function toHtml(string $mjml, array $options = []): string
    {
        return $this->convert($mjml, $options)->html();
    }

    protected function callMjml(string $mjml, array $options = []): MjmlResult
    {
        $arguments = [
            $mjml,
            $this->configOptions($options),
        ];

        $process = new Process(
            $this->getCommand($arguments),
            $this->workingDirectory,
        );

        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $resultString = $process->getOutput();

        $resultProperties = json_decode($resultString, true);

        if (array_key_exists('mjmlError', $resultProperties)) {
            throw CouldNotConvertMjml::make($resultProperties['mjmlError']);
        }

        return new MjmlResult($resultProperties);
    }

    protected function getCommand(array $arguments): array
    {
        return [
            (new ExecutableFinder())->find('node', 'node', [
                '/usr/local/bin',
                '/opt/homebrew/bin',
            ]),
            'mjml.mjs',
            json_encode(array_values($arguments)),
        ];
    }

    protected function configOptions(array $overrides): array
    {
        $defaults = [
            'keepComments' => $this->keepComments,
            'ignoreIncludes' => $this->ignoreIncludes,
            'beautify' => $this->beautify,
            'minify' => $this->minify,
            'validationLevel' => $this->validationLevel->value,
            'filePath' => $this->filePath,
        ];

        return array_merge($defaults, $overrides);
    }
}
