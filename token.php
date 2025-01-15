<?php
// Retorna o token
require "utils.php";
$access_token = http_request("https://flash-cards-fastapi.vercel.app/api/token/", "POST", json_encode(["username"=>"jackson","password"=>"Dragon132#."]), ["Content-Type: application/json"]);
echo json_encode(["access_token" => $access_token]);
var_dump($access_token);