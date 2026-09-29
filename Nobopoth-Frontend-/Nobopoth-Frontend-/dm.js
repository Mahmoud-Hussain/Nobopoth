const digitalMarketingQuestions = [
    {
      question: "What is the main goal of digital marketing?",
      answers: [
        { text: "Increase brand awareness", correct: true },
        { text: "Create attractive designs", correct: false },
        { text: "Write articles", correct: false },
        { text: "Build websites", correct: false },
      ],
    },
    {
      question: "Which social media platform is best for B2B marketing?",
      answers: [
        { text: "Facebook", correct: false },
        { text: "LinkedIn", correct: true },
        { text: "Instagram", correct: false },
        { text: "TikTok", correct: false },
      ],
    },
    {
      question: "What does SEO stand for?",
      answers: [
        { text: "Search Engine Optimization", correct: true },
        { text: "Social Engagement Optimization", correct: false },
        { text: "Search Engaging Output", correct: false },
        { text: "Software Enhanced Optimization", correct: false },
      ],
    },
    {
      question: "What is Google Analytics used for?",
      answers: [
        { text: "Monitor website traffic", correct: true },
        { text: "Create marketing campaigns", correct: false },
        { text: "Generate content ideas", correct: false },
        { text: "Track inventory", correct: false },
      ],
    },
    {
      question: "What is PPC advertising?",
      answers: [
        { text: "Pay Per Click", correct: true },
        { text: "Pay Per Conversion", correct: false },
        { text: "Post Paid Conversion", correct: false },
        { text: "Price Per Conversion", correct: false },
      ],
    },
  ];
  
  let currentQuestionIndexDM = 0;
  let scoreDM = 0;
  
  const questionElementDM = document.getElementById("question");
  const answerButtonsElementDM = document.getElementById("answer-buttons");
  const nextButtonDM = document.getElementById("next-btn");
  
  function startTestDM() {
    currentQuestionIndexDM = 0;
    scoreDM = 0;
    nextButtonDM.textContent = "Next";
    showQuestionDM();
  }
  
  function showQuestionDM() {
    resetStateDM();
    const currentQuestion = digitalMarketingQuestions[currentQuestionIndexDM];
    questionElementDM.textContent = currentQuestion.question;
  
    currentQuestion.answers.forEach((answer) => {
      const button = document.createElement("button");
      button.textContent = answer.text;
      button.classList.add("btn");
      if (answer.correct) {
        button.dataset.correct = answer.correct;
      }
      button.addEventListener("click", selectAnswerDM);
      answerButtonsElementDM.appendChild(button);
    });
  }
  
  function resetStateDM() {
    nextButtonDM.style.display = "none";
    while (answerButtonsElementDM.firstChild) {
      answerButtonsElementDM.removeChild(answerButtonsElementDM.firstChild);
    }
  }
  
  function selectAnswerDM(e) {
    const selectedButton = e.target;
    const isCorrect = selectedButton.dataset.correct === "true";
    if (isCorrect) {
      selectedButton.classList.add("correct");
      scoreDM++;
    } else {
      selectedButton.classList.add("wrong");
    }
  
    Array.from(answerButtonsElementDM.children).forEach((button) => {
      if (button.dataset.correct === "true") {
        button.classList.add("correct");
      }
      button.disabled = true;
    });
  
    nextButtonDM.style.display = "block";
  }
  
  function showScoreDM() {
    resetStateDM();
    questionElementDM.textContent = `You scored ${scoreDM} out of ${digitalMarketingQuestions.length}!`;
    nextButtonDM.textContent = "Restart";
    nextButtonDM.style.display = "block";
  }
  
  function handleNextButtonDM() {
    currentQuestionIndexDM++;
    if (currentQuestionIndexDM < digitalMarketingQuestions.length) {
      showQuestionDM();
    } else {
      showScoreDM();
    }
  }
  
  nextButtonDM.addEventListener("click", () => {
    if (currentQuestionIndexDM < digitalMarketingQuestions.length) {
      handleNextButtonDM();
    } else {
      startTestDM();
    }
  });
  
  startTestDM();
  