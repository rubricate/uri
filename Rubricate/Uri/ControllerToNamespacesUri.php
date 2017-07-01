<?php 

/*
 * @package     RubricatePHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://rubricate.github.io
 * @copyright   2016 - 2017
 * 
 */



namespace Rubricate\Uri;


class ControllerToNamespacesUri implements IGetControllerUri
{

    private $controller;


    public function __construct(IGetControllerUri $uri)
    {
        self::init($uri);
    }






    public function getController()
    {
        return $this->controller;
    } 







    private function init(IGetControllerUri $uri)
    {

        $uriControllerArr = explode('_', $uri->getController());

        $namespace = array();

        foreach ($uriControllerArr as $ns)
        {
            $namespace[] = ucfirst($ns);
        }

        $this->controller = implode('\\', $namespace);

        return $this;


    } 




}


