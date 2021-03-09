# Hunter.io

[![Latest Version on Packagist](https://img.shields.io/packagist/v/messerli90/hunterio.svg?style=flat-square)](https://packagist.org/packages/messerli90/hunterio)
[![Build Status](https://img.shields.io/travis/messerli90/hunterio/main.svg?style=flat-square)](https://travis-ci.org/messerli90/hunterio)
[![Quality Score](https://img.shields.io/scrutinizer/g/messerli90/hunterio.svg?style=flat-square)](https://scrutinizer-ci.com/g/messerli90/hunterio)
[![Total Downloads](https://img.shields.io/packagist/dt/messerli90/hunterio.svg?style=flat-square)](https://packagist.org/packages/messerli90/hunterio)

Using this package you can easily query the [Hunter.io](https://hunter.io/) API.

Here are some examples of the provided methods:

```php
use Hunter;

// Retrieve email addresses at a given domain
Hunter::domainSearch('ghost.org')

// Retrieve email addresses of people with a marketing title from ghost.org
Hunter::domainSearch()->domain('ghost.org')->department('marketing')->get();

// Find an email address belonging to John Doe working at Ghost
Hunter::emailFinder()->company('Ghost')->name('John Doe')->get();
```

## Installation

> Requires Laravel 8+ and PHP 7.4+
> 
> For Laravel 7 use `messerli90/hunter@1.1.0`

You can install the package via composer:

```bash
composer require messerli90/hunterio
```

You'll need an [API key](https://hunter.io/api) from Hunter.io

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

Read the [Hunter.io API Documentation](https://hunter.io/api-documentation/v2) to check how to handle each endpoint's response.

### Domain Search

Search all the email addresses corresponding to one website.

```php
// Shortcut to search by domain
Hunter::domainSearch('ghost.org')

// Specify searching by company name or domain
Hunter::domainSearch()->company('Ghost')->get();
Hunter::domainSearch()->domain('ghost.org')->get();

// Narrow your search by chaining attributes
$query = Hunter::domainSearch()->company('Ghost')->domain('ghost.org')
    ->seniority(['senior', 'executive'])->department('marketing')
    ->limit(5)->skip(5)->type('personal')
    ->get();
```

### Email Finder

This API endpoint generates or retrieves the most likely email address from a domain name, a first name and a last name.

```php
// Shortcut assumes searching by domain
Hunter::emailFinder('ghost.org')->name('John', 'Doe')->get();

// Search by first and last name
Hunter::emailFinder()->domain('ghost.org')->name('John', 'Doe')->get();

// or use a single string to search by 'full name'
Hunter::emailFinder()->company('Ghost')->name('John Doe')->get();
```

### Email Count

This API endpoint allows you to know how many email addresses we have for one domain or for one company. It's free and doesn't require authentication.

> This endpoint is public does not require an API key

```php
// Passing argument assumes searching by domain
Hunter::emailCount('ghost.org');

// Or specify domain or company name
Hunter::emailCount()->company('Ghost')->get();

// Narrow search to only 'personal' addresses
Hunter::emailCount()->domain('ghost.org')->type('personal')->get();
```

### Email Verifier

This API endpoint allows you to verify the deliverability of an email address.

```php
Hunter::verifyEmail('steli@close.io');
```

### Account

This API endpoint enables you to get information regarding your Hunter account at any time.

```php
Hunter::account();
```

---

### Testing

```bash
./vendor/bin/phpunit
```

### Roadmap

-   [x] Domain Search
-   [x] Email Finder
-   [x] Email Verifier
-   [x] Email Count
-   [x] Account Information
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
