<?php

namespace App\Http;

class Response{
  private $httpCode=200;
  private $headers = [];

  /**
   * Tipo de conteúdo que está sendo retornado
   * @var string
   */
  private $contentType = 'text/html';

  /**
   * Conteúdo do Response
   * @var mixed
   */
  private $content;

  public function __construct($httpCode, $content, $contentType = 'text/html'){
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->setContentType($contentType);
  }


  private function sendHeader(){
    // Status code
    http_response_code($this->httpCode);

    // Envia os headers
    foreach ($this->headers as $key => $value) {
      header($key.': '.$value);
    }
  }
  /**
   * Envia os headers para o navegador
   */
  public function setContentType($contentType){
    $this->contentType = $contentType;
    $this->addHeader('Content-Type', $contentType);
  }

  /**
   * Adiciona um registro no cabeçalho de resposta
   * @param string $key
   * @param string $value
   */
  public function addHeader($key, $value){
    $this->headers[$key] = $value;
  }

  /**
   * Metodo responsavel por enviar a resposta para o usuário
   * @return void
   */
  public function sendResponse(){
    // Envia os headers
    $this -> sendHeader();

    // Apartir do content type, o retorno do response será feito de forma diferente
    switch ($this->contentType) {
      case 'text/html':
        header('Content-Type: text/html; charset=utf-8');
        echo $this->content;
        exit;

      case 'application/json':
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->content, JSON_UNESCAPED_UNICODE);
        exit;
    }
   
  }
}
