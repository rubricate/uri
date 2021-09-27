<?php 

namespace Rubricate\Uri;

use Rubricate\Filter\Preserve\AlnumUnderscoreHyphenPreserveFilter;

class CoreUri implements IUri
{
    private $alnumPreserve;
    private $str;
    private $controller;
    private $action;
    private $param     = array();
    private $initParam = array('Index', 'index');

    public function __construct($routes = [])
    {
        $this->alnumPreserve = new AlnumUnderscoreHyphenPreserveFilter();

        self::setRoute($routes);
        self::init();
    }

    private function setRoute($r)
    {
        $q = $_SERVER['QUERY_STRING'] ;
        $router = new RouterUri($r, $q);

        $this->q = $router->getStr();
    } 

    private function init()
    {
        $uri        = self::getArr();
        $isAction   = (array_key_exists(1, $uri));
        $controller = ucfirst($uri[0]);
        $action     = (!$isAction)? $this->initParam[1]: lcfirst($uri[1]);

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

    public function getArr()
    {
        $i = ( !empty($this->q) );
        $p = $this->initParam;

        return (!$i)? $p: explode('/', trim($this->q, '/'));
    } 

    public function getStr()
    {
       return implode('/', self::getArr());
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

