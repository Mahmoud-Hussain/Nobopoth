// Review Modal Logic
const reviewBtn = document.querySelector('.review-btn');
const reviewModal = document.getElementById('reviewModal');
const closeReview = document.getElementById('closeReview');

reviewBtn.addEventListener('click', () => {
  reviewModal.style.display = 'block';
});

closeReview.addEventListener('click', () => {
  reviewModal.style.display = 'none';
});

window.addEventListener('click', (event) => {
  if (event.target == reviewModal) {
    reviewModal.style.display = 'none';
  }
});

// Chatbot Box Logic
const chatbotBtn = document.querySelector('.chatbot-btn');
const chatbotBox = document.getElementById('chatbotBox');
const closeChatbot = document.getElementById('closeChatbot');

chatbotBtn.addEventListener('click', () => {
  chatbotBox.style.display = 'block';
});

closeChatbot.addEventListener('click', () => {
  chatbotBox.style.display = 'none';
});

window.addEventListener('click', (event) => {
  if (event.target == chatbotBox) {
    chatbotBox.style.display = 'none';
  }
});

document.getElementById('sendChat').addEventListener('click', () => {
  const chatInput = document.getElementById('chatInput');
  const message = chatInput.value;
  if (message.trim()) {
    // Add message to chatbot container
    const messageElement = document.createElement('p');
    messageElement.textContent = `You: ${message}`;
    document.getElementById('chatbotContainer').appendChild(messageElement);
    chatInput.value = '';
    // Here you can add logic to send the message to the AI and display the response
  }
});

// Enrolled Students Box Logic
const studentsBtn = document.querySelector('.students-btn');
const studentBox = document.getElementById('studentBox');
const closeStudent = document.getElementById('closeStudent');

studentsBtn.addEventListener('click', () => {
  studentBox.style.display = 'block';
});

closeStudent.addEventListener('click', () => {
  studentBox.style.display = 'none';
});

window.addEventListener('click', (event) => {
  if (event.target == studentBox) {
    studentBox.style.display = 'none';
  }
});