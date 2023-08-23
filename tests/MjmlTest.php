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
    $mjml = <<<'MJML'
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

    $result = Mjml::new()->convert($mjml);

    expect($result)->hasErrors()->toBeTrue();

    expect($result->errors()[0])
        ->line->toBe(5)
        ->message->toBe('Attribute invalid-attribute is illegal')
        ->tagName->toBe('mj-text');
});

it('can verify if a string contains mjml tags', function () {
    expect(Mjml::isMjml(mjmlSnippet()))->toBeTrue()
        ->and(Mjml::isMjml('<mjml></mjml>'))->toBeTrue()
        ->and(Mjml::isMjml('<html></html>'))->toBeFalse();
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
