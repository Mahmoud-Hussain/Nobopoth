const graphicsDesignQuestions = [
    {
      question: "Which software is used for vector graphics?",
      answers: [
       
        { text: "Photoshop", correct: false },
        { text: "CorelDRAW", correct: false },
        { text: "InDesign", correct: false },
        { text: "Adobe Illustrator", correct: true },
      ],
    },
    {
      question: "What is the main purpose of a logo?",
      answers: [
        { text: "Brand recognition", correct: true },
        { text: "Visual appeal", correct: false },
        { text: "Decoration", correct: false },
        { text: "Text styling", correct: false },
      ],
    },
    {
      question: "What does RGB stand for in design?",
      answers: [
        { text: "Red, Green, Blue", correct: true },
        { text: "Red, Gold, Black", correct: false },
        { text: "Realistic Gradient Brush", correct: false },
        { text: "Radial Grid Brush", correct: false },
      ],
    },
    {
      question: "What is the purpose of a mood board?",
      answers: [
        
        { text: "Enhance productivity", correct: false },
        { text: "Inspire creativity", correct: true },
        { text: "Define color palettes", correct: false },
        { text: "Improve typography", correct: false },
      ],
    },
    {
      question: "Which file format is best for high-quality print designs?",
      answers: [
       
        { text: "JPEG", correct: false },
        { text: "PNG", correct: false },
        { text: "PDF", correct: true },
        { text: "GIF", correct: false },
      ],
    },
  ];
  
  let currentQuestionIndex = 0;
  let score = 0;
  
  const questionElement = document.getElementById("question");
  const answerButtonsElement = document.getElementById("answer-buttons");
  const nextButton = document.getElementById("next-btn");
  
  function startTest() {
    currentQuestionIndex = 0;
    score = 0;
    nextButton.textContent = "Next";
    showQuestion();
  }
  
  function showQuestion() {
    resetState();
    const currentQuestion = graphicsDesignQuestions[currentQuestionIndex];
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
    questionElement.textContent = `You scored ${score} out of ${graphicsDesignQuestions.length}!`;
    nextButton.textContent = "Restart";
    nextButton.style.display = "block";
  }
  
  function handleNextButton() {
    currentQuestionIndex++;
    if (currentQuestionIndex < graphicsDesignQuestions.length) {
      showQuestion();
    } else {
      showScore();
    }
  }
  
  nextButton.addEventListener("click", () => {
    if (currentQuestionIndex < graphicsDesignQuestions.length) {
      handleNextButton();
    } else {
      startTest();
    }
  });
  
  startTest();
  