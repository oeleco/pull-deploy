# Pull deploy strategy

Laravel command to deploy your code using a pull origin strategy

## Installation

You can install the package via composer:

```bash
composer require oeleco/pull-deploy
```

In earlier versions of Laravel 5.5 , is necesary add to config/app.php
```php
oeleco\PullDeploy\PullDeployServiceProvider::class
```

## Usage

``` php
php artisan pull:deploy
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please tweet me @oele_co instead of using the issue tracker.

## Credits

- [@oele_co](https://github.com/oeleco)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).