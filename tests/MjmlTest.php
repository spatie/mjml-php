<?php

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Spatie\Mjml\Mjml;
use Spatie\Mjml\MjmlResult;

it('can render mjml without any options', function () {
    $html = Mjml::new()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('can handle invalid mjml', function () {
    $invalidMjml = '<2mjml></2mjml>';

    (new Mjml())->toHtml($invalidMjml);
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

it('can beautify the rendered html', function() {
    $html = Mjml::new()->beautify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('can minify the rendered html', function() {
    $html = Mjml::new()->minify()->toHtml(mjmlSnippet());

    expect($html)->toMatchSnapshot();
});

it('can return a direct result from mjml', function() {
    $result = Mjml::new()->minify()->convert(mjmlSnippet());

    expect($result)->toBeInstanceOf(MjmlResult::class);

    expect($result)
        ->html()->toBeString()
        ->array()->toBeArray()
        ->hasErrors()->toBeFalse()
        ->errors()->toHaveCount(0);

});

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

