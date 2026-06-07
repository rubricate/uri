<?php

declare(strict_types=1);

namespace Rubricate\Uri;

use Rubricate\Filter\Preserve\AlnumDashFilter;

class CoreUri implements IUri
{
    private const INIT_PARAM = ['Index', 'index'];

    private readonly AlnumDashFilter $alnumFilter;
    private readonly string $q;
    private readonly string $controller;
    private readonly string $action;
    private readonly array $param;

    public function __construct(array $routes = [])
    {
        $this->alnumFilter = new AlnumDashFilter();

        $qStr = $_SERVER['QUERY_STRING'] ?? ltrim($_SERVER['REQUEST_URI'], '/');
        $router = new RouterUri($routes, $qStr);
        $this->q = $router->getStr() ?? '';

        $uri = $this->getArr();
        $rawController = ucfirst($uri[0] ?? self::INIT_PARAM[0]);
        $rawAction = lcfirst($uri[1] ?? self::INIT_PARAM[1]);

        $this->controller = $this->getFilter($rawController);
        $this->action = $this->getFilter($rawAction);
        $this->param = array_slice($uri, 2);
    } 

    private function getFilter(string $value): string
    {
        $value = str_replace('-', '_', $value);
        return $this->alnumFilter->getFilter($value);
    }

    public function getArr(): array
    {
        if (empty($this->q)) {
            return self::INIT_PARAM;
        }

        return explode('/', trim($this->q, '/'));
    } 

    public function getStr(): ?string
    {
       return implode('/', $this->getArr());
    } 

    public function getController(): string
    {
        return $this->controller;
    } 

    public function getAction(): string
    {
        return $this->action;
    } 

    public function getParam(int $num): ?string
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
