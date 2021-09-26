<?php

/*
 * Class Rubricate Uri
 *
 * @package     rubricate/uri
 * @link        https://rubricate.github.io/components/uri
 */

namespace Rubricate\Uri;

class RouterUri implements IGetStrUri
{
    private $routes = [];
    private $uri;



    public function __construct($routes = [], $queryString = null)
    {
        self::init($routes, $queryString);
    }



    public function init($rt, $qr)
    {
        self::setRouteAndQrStr($rt, $qr);

        foreach ($this->routes as $urik => $uriv) {

            $pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $urik);

            if(preg_match(sprintf('#^(%s)*$#i', $pattern), $this->uri, $matches) === 1){
                array_shift($matches);
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



    public function getStr()
    {
        return $this->uri;
    }



    private function setRouteAndQrStr($rt, $qr)
    {
        $q = $qr;
        $s = $_SERVER['QUERY_STRING'] ;
        $u = (is_null($q)) ? $s: $q;

        $this->uri = (!empty($u))? $u: '/';
        $this->routes = $rt;
    }


}    

