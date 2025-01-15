<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcards Interativos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">CURLOPT_SSL_VERIFYHOST => 0,
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/style.css">
    

</head>
<body>
    <div class="main">
        <h1>Flashcards Interativos</h1>
        <div class="flashcardContainer">
            <div class="card" id="flashcard">
                <div class="cardFace cardFront">
                    <h2 id="question">Loading...</h2>
                </div>
                <div class="cardFace cardBack">
                    <p id="answer">Loading...</p>
                </div>
            </div>
        </div>
        <div class="buttons">
            <button id="textToVoiceButton" class="button">
                <i class="fa-solid fa-headphones"></i>
            </button>
            <button id="nextCardButton" class="button yellow">
                <i class="fa-solid fa-forward"></i>
            </button>
        </div>
    </div>

<script>
    const questionElement = document.getElementById("question");
    const answerElement = document.getElementById("answer");

    document.addEventListener("DOMContentLoaded", async () => {
    try {
        const tokenResponse = await fetch("token.php");
        const { access_token } = await tokenResponse.json();

        const response = await fetch("https://flash-cards-fastapi.vercel.app/api/aleatory_card/", {
            headers: {
                Authorization: `Bearer ${access_token}`,
                "Content-Type": "application/json",
            },
        });
        const data = await response.json();
        document.getElementById("question").textContent = data.question;
    } catch (error) {
        document.getElementById("question").textContent = "Erro ao carregar o flashcard.";
    }
});


</script>
</body>
</html>
