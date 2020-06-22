# Hunter.io

[![Latest Version on Packagist](https://img.shields.io/packagist/v/messerli90/hunterio.svg?style=flat-square)](https://packagist.org/packages/messerli90/hunterio)
[![Build Status](https://img.shields.io/travis/messerli90/hunterio/master.svg?style=flat-square)](https://travis-ci.org/messerli90/hunterio)
[![Quality Score](https://img.shields.io/scrutinizer/g/messerli90/hunterio.svg?style=flat-square)](https://scrutinizer-ci.com/g/messerli90/hunterio)
[![Total Downloads](https://img.shields.io/packagist/dt/messerli90/hunterio.svg?style=flat-square)](https://packagist.org/packages/messerli90/hunterio)

This is a Laravel PHP wrapper for the [Hunter.io](https://hunter.io/) API.

> Requires PHP 7.3+

## Installation

You can install the package via composer:

```bash
composer require messerli90/hunterio
```

Get an API key at [https://hunter.io/api](https://hunter.io/api)

## Usage

Each API call comes with it's own Facade which can be built up by chaining the attributes you want to include

### Domain Search

Search all the email addresses corresponding to one website.

```php
// Search by company name or website
DomainSearch::company('Ghost')->get();
DomainSearch::domain('ghost.org')->get();

// Build your query by chaining attributes
$query = DomainSearch::company('Ghost')->seniority(['senior', 'executive'])->department('marketing')->make();

// https://api.hunter.io/v2/domain-search?company=Ghost&limit=10&api_key=XXX
```

All available setters

```php
// Set domain to search
DomainSearch::domain('ghost.org');

// Set company to search
DomainSearch::company('Ghost');

// Set max number of emails to return
DomainSearch::limit(10);

// Set number of email to skip
DomainSearch::skip(5);

// Set the type of email addresses to search (generic or personal)
DomainSearch::type('generic');

// Set the selected seniority levels to include in search
DomainSearch::seniority('junior');
DomainSearch::seniority(['junior', 'senior']);

// Set the selected departments to include in search
DomainSearch::departments('support');
DomainSearch::departments(['support', 'hr']);
```

### Testing

To test this package replace `phpunit.xml` with `phpunit.xml.dist` and use your Hunter API in `HUNTER_API_KEY`

```bash
./vendor/bin/pest
```

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
