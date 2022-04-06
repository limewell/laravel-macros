# laravel-macros

[![Latest Version on Packagist](https://img.shields.io/packagist/v/limewell/laravel-macros.svg?style=flat-square)](https://packagist.org/packages/limewell/laravel-macros)
[![Total Downloads](https://img.shields.io/packagist/dt/limewell/laravel-macros.svg?style=flat-square)](https://packagist.org/packages/limewell/laravel-macros)
![GitHub Actions](https://github.com/limewell/laravel-macros/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require limewell/laravel-macros
```

## Usage

### Eloquent Builder
withWhereHas()
```php
User::query()
    ->withWhereHas('subscriptions', function ($query) {
        $query->where('package_id', 4)->withWhereHas('package');
    })
    ->get();
```
### Schema Blueprint
hasForeign()
```php
Schema::table('subscriptions', function (Blueprint $table) {
    if($table->hasForeign('subscriptions_package_id_foreign')){
        //
    }
});
```
### Collection
loadWithLimit()
```php
Country::all()
    ->loadWithLimit(['states' => function($query){
        $query->limit(1);
    }]);
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email dipesh.sukhia@gmail.com instead of using the issue tracker.

## Credits

-   [Dipesh Sukhia](https://github.com/limewell)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
