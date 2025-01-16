<?php
  require "utils.php";
  ini_set("display_errors", 0);

  session_start();


  if(isset($_SESSION["access_token"]) && verifyToken($_SESSION["access_token"])) {
     header("Location: index.php");
  }

  if($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST['username']?? "";
    $password = $_POST['password']?? "";

    $data = ["username" => $username, "password" => $password];
    try{
      $access_token = http_request("https://flash-cards-fastapi.vercel.app/token", "POST",$data, ["Content-Type: application/json"]);
      $response = json_decode($access_token)->access_token;
      
      if($response) {
        session_start();
        $_SESSION['access_token'] = $response;
        header("Location: index.php");
      }
      $error = "Usuário ou senha inválidos";
    
    }
    catch (Exception $e) {
      $e -> getMessage();
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Login</title>

  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <main class="main">
    <form class="form-login" action="login.php" method="post">
      <label for="username">usuário</label>
      <input type="text" name="username" id="username">
      <label for="password">senha</label>
      <div class="password-container">
        <input type="password" name="password" id="password">
        <i class="fa-solid fa-eye"></i>
      </div>
        
      <button type="submit">Login</button>
      <?php
        if(isset($error)) {
        echo "<p class='error'>Error: $error</p>";
        }
      ?>
    </form>
    <script>
      const eye = document.querySelector(".fa-eye");
      const password = document.querySelector("#password");
      eye.addEventListener("click", () => {
        if(password.type === "password") {
          password.type = "text";
        } else {
          password.type = "password";
        }
      });
    </script>
  </main>
</body>
</html>