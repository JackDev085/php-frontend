<?php

namespace App\Http;

class Request{
    private $httpMethod;
    private $url;
    private $queryParamns = [];
    private $postVars = [];
    private $headers = [];

    public function __construct()
    {
        $this->queryParamns = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders() ?? [];
        $this->httpMethod = $_SERVER["REQUEST_METHOD"] ??"GET";
        $this ->url = $_SERVER["REQUEST_URI"] ??"";
    }
}