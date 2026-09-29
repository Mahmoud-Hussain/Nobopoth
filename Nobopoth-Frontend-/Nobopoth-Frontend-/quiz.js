const questions = [
    {
      question: "What will be the output of the following code?\n\nconsole.log(typeof NaN);",
      answers: [

        { text: "'undefined'", correct: false },
        { text: "'number'", correct: true },
        { text: "'NaN'", correct: false },
        { text: "'object'", correct: false },
      ],
    },
    {
      question: "How can you reverse a string in JavaScript? Select the correct snippet.",
      answers: [

        { text: "str.reverse().split('')", correct: false },
        { text: "str.join('').reverse()", correct: false },
        { text: "str.split('').reverse().join('')", correct: true },
        { text: "str.reverseString()", correct: false },
      ],
    },
    {
      question: "Which function will return the largest number in an array?",
      answers: [
        { text: "Math.max(...arr)", correct: true },
        { text: "Math.max(arr)", correct: false },
        { text: "Math.maximum(arr)", correct: false },
        { text: "arr.max()", correct: false },
      ],
    },
    {
      question: "What is the output of the following code?\n\nlet x;\nconsole.log(x + 1);",
      answers: [
        { text: "NaN", correct: true },
        { text: "undefined", correct: false },
        { text: "1", correct: false },
        { text: "Error", correct: false },
      ],
    },
    {
      question: "Write a function to check if a number is even or odd. Which method is correct?",
      answers: [
        { text: "function isEven(n) { return n / 2; }", correct: false },
        { text: "function isEven(n) { return n % 2 !== 1; }", correct: false },
        { text: "function isEven(n) { return n % 3 === 0; }", correct: false },
        { text: "function isEven(n) { return n % 2 === 0; }", correct: true },
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
    const currentQuestion = questions[currentQuestionIndex];
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
    questionElement.textContent = `You scored ${score} out of ${questions.length}!`;
    nextButton.textContent = "Restart";
    nextButton.style.display = "block";
  }
  
  function handleNextButton() {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
      showQuestion();
    } else {
      showScore();
    }
  }
  
  nextButton.addEventListener("click", () => {
    if (currentQuestionIndex < questions.length) {
      handleNextButton();
    } else {
      startQuiz();
    }
  });
  
  startQuiz();
  