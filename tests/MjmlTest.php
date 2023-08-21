<?php

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

    $html = (new Mjml())->toHtml($mjml);

    expect($html)->toMatchSnapshot();
});
