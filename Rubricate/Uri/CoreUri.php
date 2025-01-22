<?php 

declare(strict_types=1);

namespace Rubricate\Uri;

use Rubricate\Filter\Preserve\AlnumUnderscoreHyphenPreserveFilter;

class CoreUri implements IUri
{
    private AlnumUnderscoreHyphenPreserveFilter $alnumPreserve;
    private string $q = '';
    private string $controller = '';
    private string $action = '';
    private array $param = [];
    private array $initParam = ['Index', 'index'];

    public function __construct(array $routes = [])
    {
        $this->alnumPreserve = new AlnumUnderscoreHyphenPreserveFilter();

        self::setRoute($routes);
        self::init();
    }

    private function setRoute(array $routes): void
    {
        $qStr    = $_SERVER['QUERY_STRING'] ?? ltrim($_SERVER['REQUEST_URI'], '/');
        $router  = new RouterUri($routes, $qStr);
        $this->q = $router->getStr();
    } 

    private function init(): void
    {
        $uri = $this->getArr();
        $controller = ucfirst($uri[0] ?? $this->initParam[0]);
        $action = lcfirst($uri[1] ?? $this->initParam[1]);

        $this->controller = $this->getFilter($controller);
        $this->action = $this->getFilter($action);

        $this->param = array_slice($uri, 2);
    } 

    private function getFilter($value): string
    {
        $value = str_replace('-', '_', $value);
        return $this->alnumPreserve->getFilter($value);
    }

    public function getArr(): array
    {
        if (empty($this->q)) {
            return $this->initParam;
        }

        return explode('/', trim($this->q, '/'));
    } 

    public function getStr(): ?string
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
        return $this->param;
    } 

    public function getNamespaceAndController(): string
    {
        $c = explode('_', $this->getController());
        $namespace = array_map(fn($p) => ucfirst($p), $c);

        return implode('\\', $namespace);
    } 

}

