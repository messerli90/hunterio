# Hunter.io

[![Latest Version on Packagist](https://img.shields.io/packagist/v/messerli90/hunterio.svg?style=flat-square)](https://packagist.org/packages/messerli90/hunterio)
[![Build Status](https://img.shields.io/travis/messerli90/hunterio/master.svg?style=flat-square)](https://travis-ci.org/messerli90/hunterio)
[![Quality Score](https://img.shields.io/scrutinizer/g/messerli90/hunterio.svg?style=flat-square)](https://scrutinizer-ci.com/g/messerli90/hunterio)
[![Total Downloads](https://img.shields.io/packagist/dt/messerli90/hunterio.svg?style=flat-square)](https://packagist.org/packages/messerli90/hunterio)

Using this package you can easily query the [Hunter.io](https://hunter.io/) API.

Here are some examples of the provided methods:

```php
use DomainSearch;
use EmailFinder;

// Retrieve email addresses of people with a marketing title from ghost.org
DomainSearch::domain('ghost.org')->department('marketing')->get();

// Find an email address belonging to John Doe working at Ghost
EmailFinder::company('Ghost')->name('John Doe')->get();
```

## Installation

> Requires PHP 7.2+

You can install the package via composer:

```bash
composer require messerli90/hunterio
```

You'll need an API key from Hunter.io (You can grab one from [https://hunter.io/api](https://hunter.io/api))

Optionally, you can publish the config file of this package with this command:

```bash
php artisan vendor:publish --provider="Messerli90\Hunterio\HunterServiceProvider"
```

or, manually add it to your `config/services.php` file

```php
[
    ...
    'hunter' => [
        'key' => env('HUNTER_API_KEY')
    ]
]
```

## Usage

Each API endpoint comes with it's own Facade which can be built up by chaining the attributes you want to include

### Domain Search

Search all the email addresses corresponding to one website.

```php
// Search by company name or website
DomainSearch::company('Ghost')->get();
DomainSearch::domain('ghost.org')->get();

// Narrow your search by chaining attributes
$query = DomainSearch::company('Ghost')->domain('ghost.org')
    ->seniority(['senior', 'executive'])->department('marketing')
    ->limit(5)->skip(5)->type('personal')
    ->get();
```

### Email Finder

This API endpoint generates or retrieves the most likely email address from a domain name, a first name and a last name.

```php
// Search by first and last name
EmailFinder::domain('ghost.org')->name('John', 'Doe')->get();

// or use a single string to search by 'full name'
EmailFinder::company('Ghost')->name('John Doe')->get();
```

### Email Count

This API endpoint allows you to know how many email addresses we have for one domain or for one company. It's free and doesn't require authentication.

> This endpoint is public does not require an API key

```php
EmailCount::domain('ghost.org')->get();

// Narrow search to only 'personal' addresses
EmailCount::domain('ghost.org')->type('personal')->get();
```

### Testing

```bash
./vendor/bin/phpunit
```

### Roadmap

-   [x] Domain Search
-   [x] Email Finder
-   [ ] Email Verifier
-   [x] Email Count
-   [ ] Account Information
-   [ ] Leads
-   [ ] Leads List

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please tweet me at @michaelmesserli instead of using the issue tracker.

## Credits

-   [Michael Messerli](https://github.com/messerli90)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
