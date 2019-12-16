<?php 

/*
 * @package     RubricatePHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://rubricate.github.io
 * @copyright   2019
 * 
 */

namespace Rubricate\Uri;

class QrStrUri
{
    public static function get()
    {
        return trim($_SERVER['QUERY_STRING'], '/');
    } 
}    

