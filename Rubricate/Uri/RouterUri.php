<?php

namespace Rubricate\Uri;

class RouterUri extends AbstractRouterUri implements IRouterUri
{
    private $routeArr = [];


    public function addRoute($pattern, $callback) {

        parent::addRoute($pattern, $callback);

        return $this;
    }



    public function getRoute()
    {
        if (parent::isRoute()) {

            $_GET['q'] = QrStrUri::get();
            $q = $_GET['q'];


            foreach (parent::getRouteArr() as $pattern => $callback) {

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

