<?php 

/*
 * @package     RubricatePHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://rubricate.github.io
 * @copyright   2016 - 2019
 * 
 */



namespace Rubricate\Uri;

use Rubricate\Filter\Preserve\AlnumUnderscoreHyphenPreserveFilter;

class IdentifyUri
{

    private $alnumPreserve;
    private $str;
    private $controller;
    private $action;
    private $param     = array();
    private $initParam = array('Index', 'index');



    public function __construct(IRouterUri $route)
    {
        self::init($route);
    }




    private function init($route)
    {
        $this->alnumPreserve = new AlnumUnderscoreHyphenPreserveFilter();

        $uri        = self::getUriArr($route);


        $isAction   = (array_key_exists(1, $uri));
        $controller = ucfirst($uri[0]);
        $default    = $this->initParam[1];
        $action     = (!$isAction)? $default: lcfirst($uri[1]);

        $this->action     = self::getFilter($action);
        $this->controller = self::getfilter($controller);

        unset($uri[0], $uri[1]);

        $this->param = $uri;
    } 




    private function getFilter($value) 
    {
        $value = str_replace('-', '_', $value);
        return $this->alnumPreserve->getFilter($value);
    }




    private function getUriArr($route)
    {
        $rt = $route->getRoute();
        $qs = (!is_null($rt))? $rt: QrStrUri::get();
        $pr = $this->initParam;
        $ex = explode('/', $qs);

        return (!empty($qs))? $ex: $pr;
    } 




    public function getController()
    {
        return $this->controller;
    } 




    public function getAction()
    {
        return $this->action;
    } 




    public function getParam($num)
    { 
        $isParam = (array_key_exists($num, $this->param));

        return (!$isParam) ? null: $this->param[$num];
    } 




    public function getParamArr()
    {
        $isParam = (count($this->param) > 0);

        return (!$isParam) ? array(): $this->param;
    } 




    public function getNamespaceAndController()
    {
        $namespace     = array();
        $controllerArr = explode('_', self::getController());

        foreach ($controllerArr as $ns) {

            $namespace[] = ucfirst($ns);
        }

        return implode('\\', $namespace);
    } 




}

