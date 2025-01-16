<?php
require_once "utils.php";
if($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST['username']?? "";
    $plain_password = $_POST['password']?? "";
    $email = $_POST['email']?? "";
    $full_name = $_POST['name']?? "";

    $data = [
        "username" => $username,
        "plain_password" => $plain_password,
        "email"=> $email,
        "full_name" => $full_name
    ];
    try{
        $response = http_request("https://flash-cards-fastapi.vercel.app/register", "POST",$data, ["Content-Type: application/json"]);
        $response = json_decode($response);
        if(isset($response->detail)) {
            $error = $response->detail;
        } else {
            echo "<script>alert('Registration successful!');</script>";

            sleep(2);
            header("Location: login.php");
        }
    }
    catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Registro de usuário</title>
</head>
<body>
    <main class="main">
        <form class="form-login" method="post">
            <label for="name">Nome completo</label>
            <input type="text" name="name" id="name" placeholder="Digite seu nome completo" autocomplete="name">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" autocomplete="email">
            <label for="username">Usuário</label>
            <input type="text" name="username" id="username" placeholder="Digite seu usuário" autocomplete="username">
            <label for="password">Senha</label>
            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Digite sua senha" autocomplete="new-password">
                <i class="fa-solid fa-eye"></i>
            </div>
            <ul>
                    <li>
                        <span>A senha deve conter no mínimo 8 caracteres entre números e letras (sendo uma maiúscula)</span>
                    </li>
                    <br>
                    <li>
                        <span>A senha deve conter 1 carectere especial [@$!%*?&#.]</span>
                    </li>

                </ul>
            <button class="register-button" type="submit">Registrar</button>
            <?php
                if(isset($error)) {
                echo "<p class='error'>Error: $error</p>";
                }
            ?>
            <p>Já tem uma conta? <a class="register-link" href="login.php">Login</a></p>
        </form>
    </main>
    <script>
      const eye = document.querySelector(".fa-eye");
      const password = document.querySelector("#password");
      const button = document.querySelector(".register-button");
      const email = document.querySelector("#email");
      const username = document.querySelector("#username");
      const full_name = document.querySelector("#name");

        
    
      document.addEventListener("DOMContentLoaded", () => {
        button.classList.add("disabled");

        if (localStorage.getItem("email")) {
            email.value = localStorage.getItem("email");
        }
        if (localStorage.getItem("username")) {
            username.value = localStorage.getItem("username");
        }
        if (localStorage.getItem("name")) {
            full_name.value = localStorage.getItem("name");
        }

      });
      
      full_name.addEventListener("input", () => {
        const full_nameValue = full_name.value;
        if(full_nameValue.length > 0) {
            localStorage.setItem("name", full_name.value);
        }
      });

        email.addEventListener("input", () => {
            const emailValue = email.value;
            if(emailValue.length > 0) {
                localStorage.setItem("email", email.value);
            }
        });

        username.addEventListener("input", () => {
            const usernameValue = username.value;
            if(usernameValue.length > 0) {
                localStorage.setItem("username", username.value);
            }
        });

      button.classList.toggle("disabled");
    
        password.addEventListener("input", () => {
            const passwordValue = password.value;
            const regex = /^(?=.*[0-9])(?=.*[!@#$%.^&*])(?=.*[A-Z])[a-zA-Z0-9!@#$.%^&*]{8,}$/;
            if(regex.test(passwordValue)) {
                button.classList.remove("disabled");

            } else {
            button.classList.add("disabled");
            }
        });



      eye.addEventListener("click", () => {
        if(password.type === "password") {
          password.type = "text";
        } else {
          password.type = "password";
        }
      });
    </script>
</body>
</html>