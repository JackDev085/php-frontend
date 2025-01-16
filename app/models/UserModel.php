<?php

class UserModel {
    public static function login($username, $password) {
        $data = ["username" => $username, "password" => $password];
        $response = Utils::http_request("https://flash-cards-fastapi.vercel.app/token", "POST", $data, ["Content-Type: application/json"]);
        return json_decode($response, true);
    }

    public static function register($userData) {
        $response = Utils::http_request("https://flash-cards-fastapi.vercel.app/register", "POST", $userData, ["Content-Type: application/json"]);
        return json_decode($response, true);
    }

    public static function verifyToken($token) {
        $url = "https://flash-cards-fastapi.vercel.app/verify_token";
        $headers = ["Authorization: Bearer $token"];
        $response = Utils::http_request($url, "POST", null, $headers);
        return json_decode($response, true);
    }
}
