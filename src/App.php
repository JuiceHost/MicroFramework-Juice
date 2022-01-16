<?php
namespace Juice;

use Juice\Traits\SingletonTrait;
use Juice\Util\Config;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class App
{
    use SingletonTrait;
    /** @var Config */
    private $config;

    /** @var RouteCollection */
    private $routes;

    /** @var Request */
    private $request;

    /** @var RequestContext */
    private $context;

    /** @var UrlGenerator */
    private $urlGen;

    private function __construct()
    {
        $this->config = Config::create();
        $loader = new PhpFileLoader(new FileLocator());
        $this->routes = $loader->load($this->config->getConfigDir().'/routes.php');
        $this->request = Request::createFromGlobals();
        $this->context = new RequestContext();
        $this->urlGen = new UrlGenerator($this->routes, $this->context);
    }

    public function getConfig()
    {
        return $this->config;   
    }

    public function run()
    {
        $loader = new FilesystemLoader($this->config->getTemplateDir());
        $env = new Environment($loader);
        $env->addGlobal('app', $this);
        $env->addFunction(new TwigFunction('url', function(string $routeName, array $parameters = []){
            return $this->genUrl($routeName, $parameters);
        }));

        $env->addFunction(new TwigFunction('asset', function(string $fileName ){
            return $this->config->getPublicUri().'/'.$fileName;
        }));

        $matcher = new UrlMatcher($this->routes, $this->context);
        $parameters = $matcher->matchRequest($this->request);
        $controllerClass = $parameters['_controller'][0];
        $controllerObject = new $controllerClass($env);
        $controllerMethod = $parameters['_controller'][1];

        unset($parameters['_controller'], $parameters['_route']);

        $this->request->query = new InputBag($parameters);

        call_user_func([$controllerObject, $controllerMethod], $this->request);
    }

    public function genUrl(string $routeName, array $parameters = [])
    {
        return $this->config->getBaseUri().$this->urlGen->generate($routeName, $parameters); 
    }
}