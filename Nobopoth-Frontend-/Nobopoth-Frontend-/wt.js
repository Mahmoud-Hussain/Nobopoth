const writingTranslationQuestions = [
    {
      question: "What is the most important skill for a translator?",
      answers: [
        { text: "Proficiency in the target language", correct: true },
        { text: "Typing speed", correct: false },
        { text: "Knowledge of various subjects", correct: false },
        { text: "Familiarity with translation software", correct: false },
      ],
    },
    {
      question: "Which of the following is a common writing style?",
      answers: [
        { text: "Creative Writing", correct: true },
        { text: "Technical Writing", correct: false },
        { text: "Both", correct: false },
        { text: "None of the above", correct: false },
      ],
    },
    {
      question: "What does localization refer to in translation?",
      answers: [
        { text: "Adapting content for a specific locale", correct: true },
        { text: "Converting languages only", correct: false },
        { text: "Translating content for a global audience", correct: false },
        { text: "All of the above", correct: false },
      ],
    },
    {
      question: "Which writing style is used for user manuals?",
      answers: [
        { text: "Technical Writing", correct: true },
        { text: "Creative Writing", correct: false },
        { text: "Academic Writing", correct: false },
        { text: "Fiction Writing", correct: false },
      ],
    },
    {
      question: "Which tool is commonly used for writing projects?",
      answers: [
        { text: "Microsoft Word", correct: true },
        { text: "Photoshop", correct: false },
        { text: "InDesign", correct: false },
        { text: "Illustrator", correct: false },
      ],
    },
  ];
  
  let currentQuestionIndexWT = 0;
  let scoreWT = 0;
  
  const questionElementWT = document.getElementById("question");
  const answerButtonsElementWT = document.getElementById("answer-buttons");
  const nextButtonWT = document.getElementById("next-btn");
  
  function startTestWT() {
    currentQuestionIndexWT = 0;
    scoreWT = 0;
    nextButtonWT.textContent = "Next";
    showQuestionWT();
  }
  
  function showQuestionWT() {
    resetStateWT();
    const currentQuestion = writingTranslationQuestions[currentQuestionIndexWT];
    questionElementWT.textContent = currentQuestion.question;
  
    currentQuestion.answers.forEach((answer) => {
      const button = document.createElement("button");
      button.textContent = answer.text;
      button.classList.add("btn");
      if (answer.correct) {
        button.dataset.correct = answer.correct;
      }
      button.addEventListener("click", selectAnswerWT);
      answerButtonsElementWT.appendChild(button);
    });
  }
  
  function resetStateWT() {
    nextButtonWT.style.display = "none";
    while (answerButtonsElementWT.firstChild) {
      answerButtonsElementWT.removeChild(answerButtonsElementWT.firstChild);
    }
  }
  
  function selectAnswerWT(e) {
    const selectedButton = e.target;
    const isCorrect = selectedButton.dataset.correct === "true";
    if (isCorrect) {
      selectedButton.classList.add("correct");
      scoreWT++;
    } else {
      selectedButton.classList.add("wrong");
    }
  
    Array.from(answerButtonsElementWT.children).forEach((button) => {
      if (button.dataset.correct === "true") {
        button.classList.add("correct");
      }
      button.disabled = true;
    });
  
    nextButtonWT.style.display = "block";
  }
  
  function showScoreWT() {
    resetStateWT();
    questionElementWT.textContent = `You scored ${scoreWT} out of ${writingTranslationQuestions.length}!`;
    nextButtonWT.textContent = "Restart";
    nextButtonWT.style.display = "block";
  }
  
  function handleNextButtonWT() {
    currentQuestionIndexWT++;
    if (currentQuestionIndexWT < writingTranslationQuestions.length) {
      showQuestionWT();
    } else {
      showScoreWT();
    }
  }
  
  nextButtonWT.addEventListener("click", () => {
    if (currentQuestionIndexWT < writingTranslationQuestions.length) {
      handleNextButtonWT();
    } else {
      startTestWT();
    }
  });
  
  startTestWT();
  