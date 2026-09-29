<?php
session_start();
include("db_connect.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

$sender_id = $_SESSION['user_id'];
$receiver_id = null;
$job_id = null;

// Logic to fetch receiver ID and job ID based on user type
if ($_SESSION['user_type'] == 'student') {
    $sqlJ = "SELECT tj.j_id, n.employer_id FROM take_job tj 
             JOIN notifications n ON n.job_id=tj.j_id AND n.student_id = ? 
             WHERE tj.apply_status = 'Accepted'";
    $stmtJ = $conn->prepare($sqlJ);
    $stmtJ->bind_param("i", $sender_id);
    $stmtJ->execute();
    $resultJ = $stmtJ->get_result();
    $job = $resultJ->fetch_assoc();
    $job_id = $job['tj.j_id'];
    $receiver_id = $job['n.employer_id'];
} elseif ($_SESSION['user_type'] == 'employer') {
    $sqlJ = "SELECT tj.j_id, n.student_id FROM take_job tj 
             JOIN notifications n ON n.job_id=tj.j_id AND n.employer_id = ? 
             WHERE tj.apply_status = 'Accepted'";
    $stmtJ = $conn->prepare($sqlJ);
    $stmtJ->bind_param("i", $sender_id);
    $stmtJ->execute();
    $resultJ = $stmtJ->get_result();
    $job = $resultJ->fetch_assoc();
    $job_id = $job['tj.j_id'];
    $receiver_id = $job['n.student_id'];
}

// Handling message submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_text = $_POST['message_text'];
    $sql = "INSERT INTO messages (sender_id, receiver_id, job_id, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $sender_id, $receiver_id, $job_id, $message_text);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
    exit;
}

// Fetching messages (GET request)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT m.sender_id, m.receiver_id, m.message, m.timestamp 
            FROM messages m
            WHERE m.job_id = ? AND ((m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?))
            ORDER BY timestamp ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiii", $job_id, $sender_id, $receiver_id, $receiver_id, $sender_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
    $stmt->close();
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chatbox</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #chatbox-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
        }

        #chatbox {
            width: 100%;
            max-width: 400px;
            height: 80vh;
            border: 1px solid #ccc;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            background-color: white;
            overflow: hidden;
        }

        #chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            font-size: 14px;
            line-height: 1.6;
        }

        .message {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
            font-size: 14px;
        }

        .message.sent {
            background-color: #e0ffe0;
            align-self: flex-end;
        }

        .message.received {
            background-color: #e0e0ff;
            align-self: flex-start;
        }

        #chat-input {
            display: flex;
            gap: 10px;
            padding: 10px;
            border-top: 1px solid #ccc;
            background-color: #fff;
            position: sticky;
            bottom: 0;
        }

        #message-text {
            flex: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
            font-size: 14px;
        }

        #send-button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        #send-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div id="chatbox-container">
    <div id="chatbox">
        <div id="chat-messages"></div>
        <div id="chat-input">
            <textarea id="message-text" placeholder="Type your message..."></textarea>
            <button id="send-button">Send</button>
        </div>
    </div>
</div>

<script>
    const senderId = <?php echo $sender_id; ?>;
    const receiverId = <?php echo $receiver_id; ?>;
    const jobId = <?php echo $job_id; ?>;

    const chatMessages = document.getElementById("chat-messages");
    const messageText = document.getElementById("message-text");
    const sendButton = document.getElementById("send-button");

    // Fetch messages periodically
    function fetchMessages() {
        fetch("<?php echo $_SERVER['PHP_SELF']; ?>?job_id=" + jobId + "&sender_id=" + senderId + "&receiver_id=" + receiverId)
            .then(response => response.json())
            .then(data => {
                chatMessages.innerHTML = "";
                data.forEach(msg => {
                    const messageDiv = document.createElement("div");
                    messageDiv.classList.add("message", msg.sender_id == senderId ? "sent" : "received");
                    messageDiv.textContent = msg.message;
                    chatMessages.appendChild(messageDiv);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to the bottom
            });
    }

    // Send a new message
    sendButton.addEventListener("click", () => {
        const message = messageText.value.trim();
        if (message === "") return;

        fetch("<?php echo $_SERVER['PHP_SELF']; ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `sender_id=${senderId}&receiver_id=${receiverId}&job_id=${jobId}&message_text=${encodeURIComponent(message)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                messageText.value = ""; // Clear input
                fetchMessages(); // Refresh messages
            }
        });
    });

    // Fetch messages every 2 seconds
    setInterval(fetchMessages, 2000);
    fetchMessages();
</script>

</body>
</html>
