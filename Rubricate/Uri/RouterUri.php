<?php

declare(strict_types=1);

namespace Rubricate\Uri;

class RouterUri implements IGetStrUri
{
    private $routes = [];
    private $uri;

    public function __construct($routes = [], $queryString = null)
    {
        self::init($routes, $queryString);
    }

    public function init($rt, $qr): void
    {
        self::setRouteAndQrStr($rt, $qr);

        foreach ($this->routes as $urik => $uriv) {
            $pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $urik);
            if(preg_match(sprintf('#^(%s)*$#i', $pattern), $this->uri, $matches) === 1){
                array_shift($matches);

                $item = [];

                if(preg_match_all('(\{[a-z0-9]{1,}\})', $urik, $m)){
                    $item = preg_replace('(\{|\})', '', $m[0]);

                    $arg = [];
                    foreach ($matches as $key => $match) {
                        $arg[$item[$key]] = $match;
                    }

                    foreach ($arg as $ak => $av) {
                        $uriv = str_replace(':' . $ak, $av, $uriv);
                    }
                }

                $this->uri = $uriv;
                break;

            }
        }
    }

    public function getStr(): void
    {
        return $this->uri;
    }

    private function setRouteAndQrStr($rt, $qr): void
    {
        $q = $qr;
        $s = (!array_key_exists('QUERY_STRING', $_SERVER))
            ? ltrim($_SERVER['REQUEST_URI'], '/'): $_SERVER['QUERY_STRING'] ;

        $u = $q ?? $s;

        $this->uri = $u ?? 'index/index';
        $this->routes = $rt;
    }
}    

