<?php

namespace Rubricate\Uri;

class RouterUri implements IRouterUri
{
    private $routeArr = [];

    public function addRoute($pattern, $callback) {

		$pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
		$this->routeArr[$pattern] = $callback;

        return $this;
	}

    public function getQueryStr()
    {
        return trim($_SERVER['QUERY_STRING'], '/');
    } 

    public function getRoute()
    {

        if (count($this->routeArr)) {


            $_GET['q'] = self::getQueryStr();
            $q = $_GET['q'];


            foreach ($this->routeArr as $pattern => $callback) {

                if (preg_match($pattern, $q, $params)) {

                    unset($q);

                    array_shift($params);

                    $c = $callback;
                    $p = array_values($params);

                    return call_user_func_array($c, $p);

                }

            }

        }

        return null;
    } 

}    

