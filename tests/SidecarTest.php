<?php

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Spatie\Mjml\Mjml;
use Spatie\Mjml\MjmlError;
use Spatie\Mjml\MjmlResult;

it('sidecar - can render mjml without any options', function () {
    $html = Mjml::new()->sidecar()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('sidecar - can handle invalid mjml', function () {
    $invalidMjml = '<2mjml></2mjml>';

    Mjml::new()->sidecar()->toHtml($invalidMjml);
})->throws(CouldNotConvertMjml::class, 'Parsing failed. Check your mjml');

it('sidecar - will render comments by default', function () {
    $mjml = <<<'MJML'
        <mjml>
            <mj-body>
                <!-- my comment -->
            </mj-body >
        </mjml>
        MJML;

    $html = Mjml::new()->sidecar()->toHtml($mjml);

    expect($html)->toContain('<!-- my comment -->');
});

it('sidecar - can hide comments by default', function () {
    $mjml = <<<'MJML'
        <mjml>
            <mj-body>
                <!-- my comment -->
            </mj-body >
        </mjml>
        MJML;

    $html = Mjml::new()->sidecar()->hideComments()->toHtml($mjml);

    expect($html)->not->toContain('<!-- my comment -->');
});

it('sidecar - can beautify the rendered html', function () {
    $html = Mjml::new()->sidecar()->beautify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('sidecar - can minify the rendered html', function () {
    $html = Mjml::new()->sidecar()->minify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('sidecar - can return a direct result from mjml', function () {
    $result = Mjml::new()->sidecar()->minify()->convert(mjmlSnippet());

    expect($result)
        ->toBeInstanceOf(MjmlResult::class)
        ->html()->toBeString()
        ->array()->toBeArray()
        ->errors()->toHaveCount(0)
        ->hasErrors()->toBeFalse();
});

it('sidecar - can return a direct result from mjml with errors', function () {
    $result = Mjml::new()->sidecar()->convert(mjmlSnippetWithError());

    expect($result)->hasErrors()->toBeTrue();

    expect($result->errors()[0])
        ->toBeInstanceOf(MjmlError::class)
        ->line()->toBe(5)
        ->message()->toBe('Attribute invalid-attribute is illegal')
        ->tagName()->toBe('mj-text');
});

it('sidecar - can determine if the given mjml can be converted to html', function (string $mjml, bool $expectedResult) {
    expect(Mjml::new()->sidecar()->canConvert($mjml))->toBe($expectedResult);
})->with([
    [mjmlSnippet(), true],
    ['<mjml><mj-body></mj-body></mjml>', true],
    ['<html></html>', false],
    ['</mjml><mjml>', false],
    ['<html><mjml></mjml></html>', false],
]);

it('sidecar - can determine if the given mjml can be converted to html without any errors', function () {
    expect(Mjml::new()->sidecar()->canConvert(mjmlSnippetWithError()))->toBeTrue();
    expect(Mjml::new()->sidecar()->canConvertWithoutErrors(mjmlSnippetWithError()))->toBeFalse();
});
