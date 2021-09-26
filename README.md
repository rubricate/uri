# RubricatePHP Uri

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

