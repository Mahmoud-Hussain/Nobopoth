const videoAnimationQuestions = [
    {
      question: "What frame rate is commonly used for smooth video playback?",
      answers: [
        { text: "24 FPS", correct: true },
        { text: "15 FPS", correct: false },
        { text: "30 FPS", correct: false },
        { text: "60 FPS", correct: false },
      ],
    },
    {
      question: "Which software is widely used for 3D animation?",
      answers: [
        { text: "Blender", correct: true },
        { text: "Photoshop", correct: false },
        { text: "Premiere Pro", correct: false },
        { text: "Canva", correct: false },
      ],
    },
    {
      question: "What is the term for adding voice to animation?",
      answers: [
        { text: "Dubbing", correct: true },
        { text: "Lip Syncing", correct: false },
        { text: "Voice Overlay", correct: false },
        { text: "Sound Editing", correct: false },
      ],
    },
  ];
  
  let currentQuestionIndex = 0;
  let score = 0;
  
  const questionElement = document.getElementById("question");
  const answerButtonsElement = document.getElementById("answer-buttons");
  const nextButton = document.getElementById("next-btn");
  
  function startQuiz() {
    currentQuestionIndex = 0;
    score = 0;
    nextButton.textContent = "Next";
    showQuestion();
  }
  
  function showQuestion() {
    resetState();
    const currentQuestion = videoAnimationQuestions[currentQuestionIndex];
    questionElement.textContent = currentQuestion.question;
  
    currentQuestion.answers.forEach((answer) => {
      const button = document.createElement("button");
      button.textContent = answer.text;
      button.classList.add("btn");
      if (answer.correct) {
        button.dataset.correct = answer.correct;
      }
      button.addEventListener("click", selectAnswer);
      answerButtonsElement.appendChild(button);
    });
  }
  
  function resetState() {
    nextButton.style.display = "none";
    while (answerButtonsElement.firstChild) {
      answerButtonsElement.removeChild(answerButtonsElement.firstChild);
    }
  }
  
  function selectAnswer(e) {
    const selectedButton = e.target;
    const isCorrect = selectedButton.dataset.correct === "true";
    if (isCorrect) {
      selectedButton.classList.add("correct");
      score++;
    } else {
      selectedButton.classList.add("wrong");
    }
  
    Array.from(answerButtonsElement.children).forEach((button) => {
      if (button.dataset.correct === "true") {
        button.classList.add("correct");
      }
      button.disabled = true;
    });
  
    nextButton.style.display = "block";
  }
  
  function showScore() {
    resetState();
    questionElement.textContent = `You scored ${score} out of ${videoAnimationQuestions.length}!`;
    nextButton.textContent = "Restart";
    nextButton.style.display = "block";
  }
  
  function handleNextButton() {
    currentQuestionIndex++;
    if (currentQuestionIndex < videoAnimationQuestions.length) {
      showQuestion();
    } else {
      showScore();
    }
  }
  
  nextButton.addEventListener("click", () => {
    if (currentQuestionIndex < videoAnimationQuestions.length) {
      handleNextButton();
    } else {
      startQuiz();
    }
  });
  
  startQuiz();
  