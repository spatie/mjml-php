<?php

namespace Spatie\Mjml;

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Spatie\Mjml\Exceptions\SidecarPackageUnavailable;
use Spatie\MjmlSidecar\MjmlFunction;
use Spatie\TemporaryDirectory\TemporaryDirectory;
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

    protected bool $sidecar = false;

    public static function new(): self
    {
        return new static;
    }

    protected function __construct()
    {
        $this->validationLevel = ValidationLevel::Soft;
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

    public function sidecar(bool $sidecar = true): self
    {
        $this->sidecar = $sidecar;

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

    public function canConvert(string $mjml): bool
    {
        try {
            $this->convert($mjml);
        } catch (CouldNotConvertMjml) {
            return false;
        }

        return true;
    }

    public function canConvertWithoutErrors(string $mjml): bool
    {
        try {
            $result = $this->convert($mjml);
        } catch (CouldNotConvertMjml) {
            return false;
        }

        return ! $result->hasErrors();
    }

    public function toHtml(string $mjml, array $options = []): string
    {
        return $this->convert($mjml, $options)->html();
    }

    public function convert(string $mjml, array $options = []): MjmlResult
    {
        $arguments = [
            $mjml,
            $this->configOptions($options),
        ];

        if ($this->sidecar) {
            return $this->getSideCarResult($arguments);
        }

        return $this->getLocalResult($arguments);
    }

    protected function checkForDeprecationWarning(string $result): string
    {
        $deprecationWarning = 'MJML v3 syntax detected, migrating to MJML v4 syntax. Use mjml -m to get the migrated MJML.';

        if (str_contains($result, $deprecationWarning)) {
            $result = str_replace($deprecationWarning, '', $result);
        }

        return $result;
    }

    public function getCommand(string $templatePath, string $outputPath, $arguments): array
    {
        $extraDirectories = [
            '/usr/local/bin',
            '/opt/homebrew/bin',
            __DIR__.'/../node_modules/mjml/bin',
        ];

        $mjmlPathFromEnv = getenv('MJML_PATH');

        if ($mjmlPathFromEnv) {
            array_unshift($extraDirectories, $mjmlPathFromEnv);
        }

        $command = [
            (new ExecutableFinder)->find('mjml', 'mjml', $extraDirectories),
            $templatePath,
            '-o',
            $outputPath,
        ];

        foreach ($arguments as $configKey => $configValue) {
            $command[] = "-c.{$configKey}";
            $command[] = $configValue;
        }

        return $command;
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

    protected function getSideCarResult(array $arguments): MjmlResult
    {
        if (! class_exists(MjmlFunction::class)) {
            throw SidecarPackageUnavailable::make();
        }

        $result = MjmlFunction::execute([
            'mjml' => $arguments[0],
            'options' => $arguments[1],
        ])->body();

        $result = $this->checkForDeprecationWarning($result);

        $resultProperties = json_decode($result, true);

        if (array_key_exists('mjmlError', $resultProperties)) {
            throw CouldNotConvertMjml::make($resultProperties['mjmlError']);
        }

        return new MjmlResult($resultProperties);
    }

    protected function getLocalResult(array $arguments): MjmlResult
    {
        $tempDir = TemporaryDirectory::make();
        $filename = date('U');

        $templatePath = $tempDir->path("{$filename}.mjml");
        file_put_contents($templatePath, $arguments[0]);

        $outputPath = $tempDir->path("{$filename}.html");

        $command = $this->getCommand($templatePath, $outputPath, $arguments[1]);

        $process = new Process($command);
        $process->run();

        if (! $process->isSuccessful()) {
            $output = explode("\n", $process->getErrorOutput());
            $errors = array_filter($output, fn (string $output) => str_contains($output, 'Error'));

            $tempDir->delete();

            throw CouldNotConvertMjml::make($errors[0] ?? $process->getErrorOutput());
        }

        $errors = [];

        if ($process->getErrorOutput()) {
            $errors = array_filter(explode("\n", $process->getErrorOutput()));
            $errors = array_map(function (string $error) {
                preg_match('/Line (\d+) of (.+) \((.+)\) — (.+)/u', $error, $matches);
                [, $line, , $tagName, $message] = $matches;

                return [
                    'line' => $line,
                    'message' => $message,
                    'tagName' => $tagName,
                ];
            }, $errors);
        }

        $html = file_get_contents($outputPath);

        $tempDir->delete();

        return new MjmlResult([
            'html' => $html,
            'errors' => $errors,
        ]);
    }
}
