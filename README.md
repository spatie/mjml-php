# Convert MJML to HTML using PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/mjml-php.svg?style=flat-square)](https://packagist.org/packages/spatie/mjml-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/spatie/mjml-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/mjml-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/mjml-php.svg?style=flat-square)](https://packagist.org/packages/spatie/mjml-php)

[MJML](https://mjml.io) is a markup language designed to reduce the pain of coding a responsive email. Our `mjml-php` package can convert MJML to HTML.

Here's an example of how to use our package:

```php
use Spatie\Mjml\Mjml;

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

$html = Mjml::new()->toHtml($mjml);
```

The returned HTML will look like the HTML in [this snapshot file](https://github.com/spatie/mjml-php/blob/e37de853d9f89840194cf9c3302a21aae04d012b/tests/.pest/snapshots/MjmlTest/it_can_render_mjml_without_any_options.snap) (it's a bit too large to inline in this readme). Most email clients will be able to render this HTML perfectly.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/mjml-php.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/mjml-php)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/mjml-php
```

In your project, you must have the JavaScript package [`mjml`](https://github.com/mjmlio/mjml) installed.

```bash
npm install mjml
```

... or Yarn.

```bash
yarn add mjml
```

Make sure you have installed Node 16 or higher.

## Usage

Coming soon.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
