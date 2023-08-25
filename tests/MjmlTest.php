<?php

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Spatie\Mjml\Exceptions\SidecarPackageUnavailable;
use Spatie\Mjml\Mjml;
use Spatie\Mjml\MjmlError;
use Spatie\Mjml\MjmlResult;

it('can render mjml without any options', function () {
    $html = Mjml::new()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('can handle invalid mjml', function () {
    $invalidMjml = '<2mjml></2mjml>';

    Mjml::new()->toHtml($invalidMjml);
})->throws(CouldNotConvertMjml::class, 'Parsing failed. Check your mjml');

it('will render comments by default', function () {
    $mjml = <<<'MJML'
        <mjml>
            <mj-body>
                <!-- my comment -->
            </mj-body >
        </mjml>
        MJML;

    $html = Mjml::new()->toHtml($mjml);

    expect($html)->toContain('<!-- my comment -->');
});

it('can hide comments by default', function () {
    $mjml = <<<'MJML'
        <mjml>
            <mj-body>
                <!-- my comment -->
            </mj-body >
        </mjml>
        MJML;

    $html = Mjml::new()->hideComments()->toHtml($mjml);

    expect($html)->not->toContain('<!-- my comment -->');
});

it('can beautify the rendered html', function () {
    $html = Mjml::new()->beautify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('can minify the rendered html', function () {
    $html = Mjml::new()->minify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('can return a direct result from mjml', function () {
    $result = Mjml::new()->minify()->convert(mjmlSnippet());

    expect($result)
        ->toBeInstanceOf(MjmlResult::class)
        ->html()->toBeString()
        ->array()->toBeArray()
        ->errors()->toHaveCount(0)
        ->hasErrors()->toBeFalse();
});

it('can return a direct result from mjml with errors', function () {
    $result = Mjml::new()->convert(mjmlSnippetWithError());

    expect($result)->hasErrors()->toBeTrue();

    expect($result->errors()[0])
        ->toBeInstanceOf(MjmlError::class)
        ->line()->toBe(5)
        ->message()->toBe('Attribute invalid-attribute is illegal')
        ->tagName()->toBe('mj-text');
});

it('can determine if the given mjml can be converted to html', function (string $mjml, bool $expectedResult) {
    expect(Mjml::new()->canConvert($mjml))->toBe($expectedResult);
})->with([
    [mjmlSnippet(), true],
    ['<mjml><mj-body></mj-body></mjml>', true],
    ['<html></html>', false],
    ['</mjml><mjml>', false],
    ['<html><mjml></mjml></html>', false],
]);

it('can determine if the given mjml can be converted to html without any errors', function () {
    expect(Mjml::new()->canConvert(mjmlSnippetWithError()))->toBeTrue();
    expect(Mjml::new()->canConvertWithoutErrors(mjmlSnippetWithError()))->toBeFalse();
});

it('requires the sidecar package when called with sidecar', function () {
    Mjml::new()->sidecar()->toHtml(mjmlSnippet());
})->throws(SidecarPackageUnavailable::class);

function mjmlSnippet(): string
{
    return <<<'MJML'
        <mjml>
          <mj-body>
            <mj-section>
              <mj-column>
                <mj-text>Hello World</mj-text>
              </mj-column>
            </mj-section>
          </mj-body>
        </mjml>
        MJML;
}

function mjmlSnippetWithError(): string
{
    return <<<'MJML'
        <mjml>
          <mj-body>
            <mj-section>
              <mj-column>
                <mj-text invalid-attribute>Hello World</mj-text>
              </mj-column>
            </mj-section>
          </mj-body>
        </mjml>
        MJML;
}
