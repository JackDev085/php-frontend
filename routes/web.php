<?php
require "app/controllers/AuthController.php";
require "app/controllers/FlashcardController.php";
use App\Controllers\FlashcardController;

// Rota de login
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

// Rota de registro
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

// Página inicial
$router->get('/', [FlashcardController::class, 'index']);
