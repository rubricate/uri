<?php 

/*
 * @package     RubricatePHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://rubricate.github.io
 * @copyright   2016 - 2017
 * 
 */



namespace Rubricate\Uri;

use Rubricate\Filter\Preserve\AlnumUnderscoreHyphenPreserveFilter;

class Uri implements IUri, IGetParamArrUri
{

    private $alnumPreserve;
    private $str;
    private $controller;
    private $action;
    private $param     = array();
    private $initParam = array('Index', 'index');
    
    private static $instance = NULL;




    protected function __construct()
    {
        self::init();
    }






    public static function getInstance()
    {
        if(self::$instance == NULL)
        {
            self::$instance = new Uri();
        }

        return self::$instance;
    } 





    private function init()
    {
        $this->alnumPreserve = new AlnumUnderscoreHyphenPreserveFilter();

        $uri        = self::getUriArr();
        $isAction   = (array_key_exists(1, $uri));
        $controller = ucfirst($uri[0]);
        $action     = (!$isAction)? $this->initParam[1]: lcfirst($uri[1]);

        $this->action     = self::getFilter($action);
        $this->controller = self::getfilter($controller);

        unset($uri[0], $uri[1]);
        sort($uri);

        $this->param = $uri;


    } 







    private function getFilter($value) 
    {
        $value = str_replace('-', '_', $value);
        return $this->alnumPreserve->getFilter($value);
    }







    private function getUriArr()
    {
        $isUri        = array_key_exists('uri', $_GET);
        $convertToArr = explode('/', rtrim($_GET['uri'], '/'));

        return (!$isUri) ? $this->initParam : $convertToArr;
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
        return (!$isParam) ? NULL: $this->param[$num];
    } 







    public function getParamArr()
    {
        return (!count($this->param)) ? array(): $this->param;
    } 






    private function __clone() { } 
    private function __wakeup() { } 



}
