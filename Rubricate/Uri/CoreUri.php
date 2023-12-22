<?php 

declare(strict_types=1);

namespace Rubricate\Uri;

use Rubricate\Filter\Preserve\AlnumUnderscoreHyphenPreserveFilter;

class CoreUri implements IUri
{
    private $alnumPreserve;
    private $str;
    private $controller;
    private $action;
    private $param = [];
    private $initParam = ['Index', 'index'];

    public function __construct($routes = [])
    {
        $this->alnumPreserve = new AlnumUnderscoreHyphenPreserveFilter();

        self::setRoute($routes);
        self::init();
    }

    private function setRoute($r): void
    {
        $q = (!array_key_exists('QUERY_STRING', $_SERVER))
            ? ltrim($_SERVER['REQUEST_URI'], '/'): $_SERVER['QUERY_STRING'] ;

        $router = new RouterUri($r, $q);

        $this->q = $router->getStr();
    } 

    private function init(): void
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

    private function getFilter($value): string
    {
        $value = str_replace('-', '_', $value);
        return $this->alnumPreserve->getFilter($value);
    }

    public function getArr(): array
    {
        $i = ( !empty($this->q) );
        $p = $this->initParam;

        return (!$i)? $p: explode('/', trim($this->q, '/'));
    } 

    public function getStr()
    {
       return implode('/', self::getArr());
    } 

    public function getController(): string
    {
        return $this->controller;
    } 

    public function getAction(): string
    {
        return $this->action;
    } 

    public function getParam($num): ?string
    { 
        return $this->param[$num] ?? null;
    } 

    public function getParamArr(): array
    {
        return $this->param ?? [];
    } 

    public function getNamespaceAndController(): string
    {
        $namespace     = [];
        $controllerArr = explode('_', self::getController());

        foreach ($controllerArr as $ns) {

            $namespace[] = ucfirst($ns);
        }

        return implode('\\', $namespace);
    } 

}

