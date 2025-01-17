const flashcard = document.getElementById("flashcard");
const nextCardButton = document.getElementById('nextCardButton');
const textToVoiceButton = document.getElementById('textToVoiceButton');

flashcard.addEventListener("click", () => {
  flashcard.classList.toggle("cardClicked");
});




nextCardButton.addEventListener('click', async () => {
    const response = await fetch('https://flash-cards-fastapi.vercel.app/api/aleatory_card/', {
        method: 'GET',
        headers: {
            //'Authorization': 'Bearer <?php echo $_SESSION['access_token']; ?>'
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