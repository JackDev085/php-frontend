<?php

require_once 'models/UserModel.php';

class AuthController {
    public static function login() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $response = UserModel::login($username, $password);

            if (isset($response['access_token'])) {
                $_SESSION['access_token'] = $response['access_token'];
                header('Location: /dashboard'); // Direciona para a página principal
                exit();
            } else {
                $error = "Usuário ou senha inválidos";
                require 'views/login.php';
            }
        } else {
            require 'views/login.php';
        }
    }

    public static function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'username' => $_POST['username'] ?? '',
                'plain_password' => $_POST['password'] ?? '',
                'email' => $_POST['email'] ?? '',
                'full_name' => $_POST['name'] ?? ''
            ];

            $response = UserModel::register($userData);

            if (isset($response['detail'])) {
                $error = $response['detail'];
                require 'views/register.php';
            } else {
                header('Location: /login'); // Direciona para a página de login
                exit();
            }
        } else {
            require 'views/register.php';
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
