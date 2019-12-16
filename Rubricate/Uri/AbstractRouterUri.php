<?php 

/*
 * @package     RubricatePHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://rubricate.github.io
 * @copyright   2019
 * 
 */

namespace Rubricate\Uri;

abstract class AbstractRouterUri
{
    private $routeArr = [];


    protected function addRoute($pattern, $callback)
    {
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
        $this->routeArr[$pattern] = $callback;
    } 



    protected function isRoute()
    {
        return (count($this->routeArr) > 0);
    } 



    protected function getRouteArr()
    {
        return $this->routeArr;
    } 

}

