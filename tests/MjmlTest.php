<?php

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Spatie\Mjml\Exceptions\SidecarPackageUnavailable;
use Spatie\Mjml\Mjml;
use Spatie\Mjml\MjmlError;
use Spatie\Mjml\MjmlResult;

it('can render mjml to a full html document', function () {
    $html = Mjml::new()->toHtml(mjmlSnippet());

    // Assert structural markers rather than an exact-HTML snapshot: MJML v4 and v5 emit
    // materially different markup (v5 wraps in a real <body>, reorders attributes, adds
    // word-spacing), so a byte-for-byte golden can only match one major. These invariants
    // hold on both.
    expect($html)
        ->toBeString()
        ->toContain('<!doctype html>')
        ->toContain('<html')
        ->toContain('</html>')
        ->toContain('Hello World');
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

it('beautifies and minifies to distinct shapes', function () {
    $beautified = Mjml::new()->beautify()->toHtml(mjmlSnippet());
    $minified = Mjml::new()->minify()->toHtml(mjmlSnippet());

    // Assert the relationship between the two modes rather than exact-HTML snapshots (which
    // differ between MJML v4 and v5): beautified output is spread across many lines, minified
    // is collapsed onto very few. This invariant holds on both majors.
    expect($beautified)
        ->toBeString()
        ->toContain('Hello World')
        ->and($minified)
        ->toBeString()
        ->toContain('Hello World')
        ->and(substr_count($minified, "\n"))->toBeLessThan(substr_count($beautified, "\n"));
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

it('can determine if the given mjml can be converted when the mjml is deprecated', function (string $mjml, bool $expectedResult) {
    expect(Mjml::new()->canConvert($mjml))->toBe($expectedResult);
})->with([
    ['<mjml><mj-body></mj-body></mjml>', true],
    ['<mjml><mj-body><mj-wrapper></mj-wrapper></mj-body></mjml>', true],
]);

it('rejects the deprecated mj-container tag on MJML v4', function () {
    // v4 hard-rejects the removed mj-container component; v5 tolerates it. Guard the
    // assertion by the installed major so the suite passes on both.
    $canConvert = Mjml::new()->canConvert('<mjml><mj-body><mj-container></mj-container></mj-body></mjml>');

    expect($canConvert)->toBe(mjmlMajorVersion() >= 5);
});

it('can render large mjml content', function () {
    $mjml = '<mjml><mj-body>'.
            implode('', array_pad([], 10_000, '<mj-wrapper>filler</mj-wrapper>'))
            .'</mj-body></mjml>';
    $result = Mjml::new()->convert($mjml);

    expect($result)
        ->toBeInstanceOf(MjmlResult::class)
        ->html()->toBeString()
        ->errors()->toHaveCount(0)
        ->hasErrors()->toBeFalse();
});

it('can render utf8 mjml content', function () {
    $content = 'Grüsse 👋';
    $mjml = '<mjml><mj-body><mj-text>'.$content.'</mj-text></mj-body></mjml>';
    $html = Mjml::new()->toHtml($mjml);

    expect($html)->toContain($content);
});

function mjmlMajorVersion(): int
{
    $packageJson = dirname(__DIR__).'/node_modules/mjml/package.json';

    if (! is_file($packageJson)) {
        return 0;
    }

    $decoded = json_decode((string) file_get_contents($packageJson), true);
    $version = is_array($decoded) ? ($decoded['version'] ?? '0') : '0';

    return (int) explode('.', (string) $version)[0];
}

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
