<?php
require "utils.php";

session_start();
if (!isset($_SESSION['access_token'])) {
    header("Location: login.php");
    exit();
}
if (!verifyToken($_SESSION['access_token'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

function nextCard() {
    $access_token = $_SESSION['access_token'];
    $flashcards = http_request("https://flash-cards-fastapi.vercel.app/api/aleatory_card/", "GET", null, ["Authorization: Bearer $access_token"]);
    $flashcards = json_decode($flashcards);
    return $flashcards;
}

$flashcards = nextCard();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcards Interativos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main">
        <h1>Flashcards Interativos</h1>
        <div class="flashcardContainer">
            <div class="card" id="flashcard">
                <div class="id">
                    <p id="id" hidden><?php echo $flashcards->id; ?></p>
                </div>
                <div class="cardFace cardFront">
                    <h2 id="question"><?php echo $flashcards->question; ?></h2>
                </div>
                <div class="cardFace cardBack">
                    <p id="answer"><?php echo $flashcards->answer; ?></p>
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
    <script type="module" src="js/main.js"></script>
    <script>
        const nextCardButton = document.getElementById('nextCardButton');
        const textToVoiceButton = document.getElementById('textToVoiceButton');

        nextCardButton.addEventListener('click', async () => {
            const response = await fetch('https://flash-cards-fastapi.vercel.app/api/aleatory_card/', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer <?php echo $_SESSION['access_token']; ?>'
                }
            });
            const flashcard = await response.json();
            document.getElementById('question').innerText = flashcard.question;
            document.getElementById('answer').innerText = flashcard.answer;
            document.getElementById('id').innerText = flashcard.id;
        });

        textToVoiceButton.addEventListener('click', async () => {
            textToVoiceButton.classList.add('disabled');
            textToVoice();
            setTimeout(() => {
                textToVoiceButton.classList.remove('disabled');
            }, 2500);
        });

        function textToVoice() {
            const speech = new SpeechSynthesisUtterance();
            speech.text = document.getElementById('question').textContent;
            speech.volume = 1;
            speech.rate = 1;
            speech.pitch = 1;
            let voices = window.speechSynthesis.getVoices();
            if (voices.length === 0) {
                window.speechSynthesis.onvoiceschanged = () => {
                    voices = window.speechSynthesis.getVoices();
                    speech.voice = voices.find(voice => voice.lang === 'en-US') || voices[0];
                    window.speechSynthesis.speak(speech);
                };
            } else {
                speech.voice = voices.find(voice => voice.lang === 'en-US') || voices[0];
                window.speechSynthesis.speak(speech);
            }
        }
    </script>
</body>
</html>
