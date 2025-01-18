<?php

namespace App\Http;
use \Closure;
use Exception;

class Router{

  /**
   * URL do projeto
   * @var string
   */
  private $url = '';

  /**
   * Prefixo de todas as rotas
   * @var string
   */
  private $prefix = '';

  /**
   * Índice de rotas
   * @var array
   */
  private $routes=[];

  /**
   * Instancia de Request
   * @var Request
   */
  private $request;

  public function __construct($url){
    $this->request = new Request();
    $this->url = $url;
    $this->setPrefix();
  }

  private function setPrefix(){
    $parseUrl = parse_url($this->url);
    $this->prefix = $parseUrl['path'] ?? '';
  }

   public function addRoute($method, $route, $params = []){

    // Valida os parâmetros
    foreach ($params as $key => $value) {
      if($value instanceof Closure){
        $params['controller'] = $value;
        unset($params[$key]);
      }
    }

    // Padrão de validação da URL
    $patternRoute = '/^'.str_replace('/','\/',$route).'$/';

    // Adiciona a rota dentro da classe
    $this->routes[$patternRoute][$method] = $params;
  }

  public function get($route, $params = []){
    return $this->addRoute('POST', $route, $params);
  }

  public function post($route, $params = []){
    return $this->addRoute('POST', $route, $params);
  }
  /**
   * Método responsável retornar a URI desconsiderando o prefixo
   * @param string $route
   * @param array $params
   * 
   */
  private function getUri(){
    $uri = $this->request->getUrl();
    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
    return end($xUri);
  }

  private function getRoute(){
    $uri = $this -> getUri();
    $httpMethod = $this->request->getHttpMethod();

    foreach ($this->routes as $patternRoute => $methods) {
      // Verifica se a URI bate com o padrão
      if(preg_match($patternRoute, $uri)){
        // Verifica o método
        if($methods[$httpMethod]){
          
          return $methods[$httpMethod];
        }
        throw new Exception("Método não permitido", 405);
      }
    }
    throw new Exception("Página não encontrada", 404);
  }
  public function run(){
    $route = $this->getRoute();
    try{
        throw new Exception("Página não encontrada", 404);

      }catch (Exception $e){
        return new Response($e->getCode(), $e->getMessage());
    }
  }
}