<?php
// Retorna o token
require "utils.php";

try{
  $data = ["username" => "jackson", "password" => "Dragon132#."];
  $access_token = http_request("https://flash-cards-fastapi.vercel.app/token", "POST",$data, ["Content-Type: application/json"]);
  $response = json_decode($access_token);
  echo $response->access_token;
}
catch (Exception $e) {
  echo $e->getMessage();
}