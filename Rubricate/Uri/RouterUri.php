<?php

declare(strict_types=1);

namespace Rubricate\Uri;

class RouterUri implements IGetStrUri
{
    private array $routes = [];
    private ?string $uri  = null;

    public function __construct(
        array $routes = [],
        ?string $queryString = null
    ){
        self::init($routes, $queryString);
    }

    private function init(array $routes, ?string $queryString): void
    {
        $this->setRouteAndQueryStr($routes, $queryString);

        foreach ($this->routes as $uriKey => $uriValue) {
            $pattern = preg_replace('/\{[a-z0-9]+\}/i', '([a-z0-9-]+)', $uriKey);

            if (preg_match(sprintf('#^%s$#i', $pattern), $this->uri, $matches) === 1) {
                array_shift($matches);

                if (preg_match_all('/\{[a-z0-9]+\}/i', $uriKey, $keys)) {
                    $keys = array_map(fn($key) => trim($key, '{}'), $keys[0]);
                    $args = array_combine($keys, $matches) ?: [];

                    foreach ($args as $key => $value) {
                        $uriValue = str_replace(":{$key}", $value, $uriValue);
                    }
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

    private function setRouteAndQueryStr(array $routes, ?string $queryString): void
    {
        $serverQuery = $_SERVER['QUERY_STRING'] ?? ltrim($_SERVER['REQUEST_URI'], '/');
        $this->uri = $queryString ?? $serverQuery ?? 'index/index';
        $this->routes = $routes;
    }
}    

