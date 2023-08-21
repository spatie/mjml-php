<?php

use Spatie\Mjml\Exceptions\CouldNotConvertMjml;
use Spatie\Mjml\Mjml;

it('can render mjml without any options', function () {
    $mjml = <<<'MJML'
        <mjml>
          <mj-body width="500">
            <mj-section background-color="#EFEFEF">
              <mj-column>
                <mj-text font-size="20px">Hello World</mj-text>
              </mj-column>
            </mj-section>
          </mj-body>
        </mjml>
        MJML;

    $html = Mjml::new()->toHtml($mjml);

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

