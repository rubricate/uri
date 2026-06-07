# RubricatePHP Uri

[![Maintainer](http://img.shields.io/badge/maintainer-@estefanionsantos-blue.svg?style=flat-square)](https://estefanionsantos.github.io/)
[![Source Code](http://img.shields.io/badge/source-rubricate/uri-blue.svg?style=flat-square)](https://github.com/rubricate/uri)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/rubricate/uri.svg?style=flat-square)](https://packagist.org/packages/rubricate/uri)
[![Latest Version](https://img.shields.io/github/release/rubricate/uri.svg?style=flat-square)](https://github.com/rubricate/uri/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/rubricate/uri.svg?style=flat-square)](https://packagist.org/packages/rubricate/uri)

A lightweight and expressive URI parser and router component with regex placeholder support for modern MVC architectures.


```
$ composer require rubricate/uri
```

.htaccess:
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php?/$1 [L]
```

- Documentation is at https://rubricate.github.io/components/uri
- issues: https://github.com/rubricate/uri/issues

### Credits
- [All Contributors](https://github.com/rubricate/uri/contributors) (Let's program)

### License

The MIT License (MIT). Please see [License File](https://github.com/rubricate/uri?tab=MIT-1-ov-file) for more information.

