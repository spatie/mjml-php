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

The returned HTML will look like the HTML in [this snapshot file](https://github.com/spatie/mjml-php/blob/main/tests/.pest/snapshots/MjmlTest/it_can_render_mjml_without_any_options.snap) (it's a bit too large to inline in this readme). Most email clients will be able to render this HTML perfectly.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/mjml-php.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/mjml-php)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/mjml-php
```

In your project, or on your server, you must have the JavaScript package [`mjml`](https://github.com/mjmlio/mjml) installed.

```bash
npm install mjml
```

... or Yarn.

```bash
yarn add mjml
```

Make sure you have installed Node 16 or higher.

## Usage

The easiest way to convert MJML to HTML is by using the `toHtml()` method.

```php
use Spatie\Mjml\Mjml;

// let's assume $mjml contains the MJML you want to convert

$html = Mjml::new()->toHtml($mjml);
```

If the MJML could not be converted at all a `Spatie\Mjml\Exceptions\CouldNotRenderMjml` exception will be thrown.

### Using `convert()`

The `toHtml()` method will just return the converted HTML. There's also a `convert()` method that will return an instance of `Spatie\Mjml\MjmlResult` that contains the converted HTML and some metadata.

```php
use Spatie\Mjml\Mjml;

// let's assume $mjml contains the MJML you want to convert

$result = Mjml::new()->convert($mjml); // returns an instance of Spatie\Mjml\MjmlResult
```

On the returned instance of `Spatie\Mjml\MjmlResult` you can call the following methods:

- `html()`: returns the converted HTML
- `array()`: returns a structured version of the given MJML
- `hasErrors()`: returns a boolean indicating if there were errors while converting the MJML
- `errors()`: returns an array of errors that occurred while converting the MJML

The `errors()` method returns an array containing instances of `Spatie\Mjml\MjmlError`. Each `Spatie\Mjml\MjmlError` has the following methods:

- `line()`: returns the line number where the error occurred
- `message()`: returns the error message
- `formattedMessage()`: returns the error message with the line number prepended
- `tagName()`: returns the name of the tag where the error occurred

### Customizing the rendering

There are various methods you can call on the `Mjml` class to customize the rendering. For instance the `minify()` method will minify the HTML that is returned.

```php
use Spatie\Mjml\Mjml;

// let's assume $mjml contains the MJML you want to convert
$minifiedHtml = Mjml::new()->minify()->toHtml($mjml);
```

These are all the methods you can call on the `Mjml` class:

- `minify()`: minify the HTML that is returned
- `beautify()`: beautify the HTML that is returned
- `hideComments()`: hide comments in the HTML that is returned
- `validationLevel(ValidationLevel $validationLevel)`: set the validation level to `strict`, `soft` or `skip`

Instead of using these dedicated methods, you could opt to pass an array with options as the second argument of the `toHtml` or  `convert` method. You can use any of the options that are mentioned in the [MJML documentation for Node.js](https://github.com/mjmlio/mjml#inside-nodejs).

```php
use Spatie\Mjml\Mjml;

// let's assume $mjml contains the MJML you want to convert
$minifiedHtml = Mjml::new()->minify()->toHtml($mjml, [
    'beautify' => true,
    'minify' => true,
]);
```

### Validating MJML

You can make sure a piece of MJML is valid by using the `canConvert()` method.

```php
use Spatie\Mjml\Mjml;

Mjml::new()->canConvert($mjml); // returns a boolean
```

If `true` is returned we'll be able to convert the given MJML to HTML. However, there may still be some errors while converting the MJML to HTML. These errors are not fatal and the MJML will still be converted to HTML. You can see these non-fatal errors when calling `errors()` on the `MjmlResult` instance that is returned when calling `convert`.

You can use `canConvertWithoutErrors` to make sure the MJML is both valid and that there are no non-fatal errors while converting it to HTML.

```php
use Spatie\Mjml\Mjml;

Mjml::new()->canConvertWithoutErrors($mjml); // returns a boolean
```

### Specifying the path to nodejs executable

By default, the package itself will try to determine the path to the `node` executable. If the package can't find a path, you can specify a path in the environment variable `MJML_NODE_PATH` 

```shell
MJML_NODE_PATH=/home/user/.nvm/versions/node/v20.11.0/bin
```

## Sidecar

This package also supports running through [Sidecar](https://github.com/hammerstonedev/sidecar) in Laravel projects.

To use the `->sidecar()` method, a few extra steps are needed:

Install the Sidecar package:

```shell
composer require spatie/mjml-sidecar
```

Register the `MjmlFunction` in your `sidecar.php` config file.

```php
/*
 * All of your function classes that you'd like to deploy go here.
 */
'functions' => [
    \Spatie\MjmlSidecar\MjmlFunction::class,
],
```

Deploy the Lambda function by running:

```shell
php artisan sidecar:deploy --activate
```

See the [Sidecar documentation](https://hammerstone.dev/sidecar/docs/main/functions/deploying) for details.

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
