<?php 

/*
 * @package     RubricatePHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://rubricate.github.io
 * @copyright   2019
 * 
 */

namespace Rubricate\Uri;

interface IRouterUri
{
    public function addRoute($pattern, $callback);

    public function getRoute();
}

