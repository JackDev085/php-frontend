<?php
function http_request($url, $method = "GET", $data = null, $headers = []) {
    $curl = curl_init();
    
    // Configurações básicas
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ]);

    // Configuração do método
    if ($method === "POST") {
        curl_setopt($curl, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        }
    }

    // Configuração dos headers
    $defaultHeaders = ["Content-Type: application/json"];
    if (!empty($headers)) {
        $defaultHeaders = array_merge($defaultHeaders, $headers);
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $defaultHeaders);

    // Executa a requisição
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        throw new Exception("Erro na requisição cURL: $err");
    }

    return $response;
}
