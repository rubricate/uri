<?php

declare(strict_types=1);

namespace Rubricate\Uri;

class RouterUri implements IGetStrUri
{
    private readonly array $routes;
    private ?string $uri = null;

    // Mapa de correspondência dos novos Placeholders para Regex
    private const PLACEHOLDERS = [
        '(:any)'       => '([^/]+)',
        '(:num)'       => '([0-9]+)',
        '(:alpha)'     => '([a-zA-Z]+)',
        '(:alnum)'     => '([a-zA-Z0-9]+)',
        '(:alnumdash)' => '([a-zA-Z0-9_-]+)',
    ];

    public function __construct(array $routes = [], ?string $queryString = null)
    {
        $this->routes = $routes;

        $serverQuery = $_SERVER['QUERY_STRING'] ?? ltrim($_SERVER['REQUEST_URI'], '/');
        $resolvedUri = $queryString ?? $serverQuery;

        $this->uri = (!is_null($resolvedUri) && $resolvedUri !== '') ? $resolvedUri : 'index/index';

        foreach ($this->routes as $uriKey => $uriValue) {

            $pattern = preg_replace('/\{[a-z0-9]+\}/i', '([a-z0-9-]+)', $uriKey);

            $pattern = str_replace(
                array_keys(self::PLACEHOLDERS),
                array_values(self::PLACEHOLDERS),
                $pattern
            );

            $cleanUriKey  = trim($uriKey, '/');
            $cleanPattern = str_replace(
                array_keys(self::PLACEHOLDERS),
                array_values(self::PLACEHOLDERS),
                $cleanUriKey
            );

            if (preg_match(sprintf('#^%s$#i', $cleanPattern), trim($this->uri, '/'), $matches) === 1) {
                array_shift($matches);

                if (preg_match_all('/\{[a-z0-9]+\}/i', $uriKey, $keys)) {
                    $keys = array_map(fn($key) => trim($key, '{}'), $keys[0]);
                    $args = array_combine($keys, $matches) ?: [];

                    foreach ($args as $key => $value) {
                        $uriValue = str_replace(":{$key}", $value, $uriValue);
                    }
                }

                foreach ($matches as $index => $matchValue) {
                    $placeholderIndex = '$' . ($index + 1);
                    $uriValue = str_replace($placeholderIndex, $matchValue, $uriValue);
                }

                $this->uri = $uriValue;
                break;
            }
        }
    }

    public function getStr(): ?string
    {
        return $this->uri;
    }
}
