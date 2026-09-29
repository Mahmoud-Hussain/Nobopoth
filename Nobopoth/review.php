<?php
session_start();
include("db_connect.php");

// Ensure the user is logged in
/*if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}*/

$reviewer_id = $_SESSION['user_id'];
$job_id = null;
$reviewee_id = null;

// Logic to fetch job ID and reviewee ID based on user type (Admin/Employer/Student)
if ($_SESSION['user_type'] == 'student') {
    // If the user is a student, the reviewee is the employer
    $sqlJ = "SELECT tj.j_id, n.employer_id FROM take_job tj
             JOIN notifications n ON n.job_id=tj.j_id AND n.student_id = ?
             WHERE tj.apply_status = 'Accepted'";
    $stmtJ = $conn->prepare($sqlJ);
    $stmtJ->bind_param("i", $reviewer_id);
    $stmtJ->execute();
    $resultJ = $stmtJ->get_result();
    $job = $resultJ->fetch_assoc();
    $job_id = $job['tj.j_id'];
    $reviewee_id = $job['n.employer_id'];
    $stmtJ->close();
} elseif ($_SESSION['user_type'] == 'employer'|| $_SESSION['user_type'] == 'admin') {
    // If the user is an employer, the reviewee is the student
    $sqlJ = "SELECT tj.j_id, n.student_id FROM take_job tj
             JOIN notifications n ON n.job_id=tj.j_id AND n.employer_id = ?
             WHERE tj.apply_status = 'Accepted'";
    $stmtJ = $conn->prepare($sqlJ);
    $stmtJ->bind_param("i", $reviewer_id);
    $stmtJ->execute();
    $resultJ = $stmtJ->get_result();
    $job = $resultJ->fetch_assoc();
    $job_id = $job['tj.j_id'];
    $reviewee_id = $job['n.student_id'];
    $stmtJ->close();
} 

// Handling review submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating']) && isset($_POST['feedback'])) {
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    // Insert the review into the review_tb table
    $sql = "INSERT INTO review_tb (reviewer_id, reviewee_id, j_id, rating, feedback) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiss", $reviewer_id, $reviewee_id, $job_id, $rating, $feedback);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
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
    <title>Review Box</title>
    <style>
        /* Styles for the review box */
        #review-container {
            width: 300px;
            padding: 1rem;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            text-align: center;
        }

        h2 {
            margin-bottom: 1rem;
        }

        #rating {
            font-size: 1.5rem;
            color: gray;
            cursor: pointer;
        }

        #rating .star {
            margin: 0 5px;
        }

        #feedback {
            width: 100%;
            height: 80px;
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 5px;
            margin: 10px 0;
        }

        #submit-review {
            padding: 0.5rem 1rem;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }

        #submit-review:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div id="review-container">
        <h2>Leave a Review</h2>
        <form id="review-form">
            <label for="rating">Rating:</label>
            <div id="rating">
                <span class="star" data-rating="1">★</span>
                <span class="star" data-rating="2">★</span>
                <span class="star" data-rating="3">★</span>
                <span class="star" data-rating="4">★</span>
                <span class="star" data-rating="5">★</span>
            </div>
            <textarea id="feedback" placeholder="Write your feedback here..."></textarea>
            <input type="hidden" id="reviewee-id" value="<?php echo $reviewee_id; ?>"> <!-- reviewee_id dynamically from PHP -->
            <button type="submit" id="submit-review">Submit Review</button>
        </form>
    </div>

    <script>
        const ratingElements = document.querySelectorAll('.star');
        let selectedRating = 0;

        // Handle star rating selection
        ratingElements.forEach(star => {
            star.addEventListener('click', function () {
                selectedRating = this.getAttribute('data-rating');
                ratingElements.forEach(star => star.style.color = 'gray');
                for (let i = 0; i < selectedRating; i++) {
                    ratingElements[i].style.color = 'gold';
                }
            });
        });

        // Handle review submission
        document.getElementById('review-form').addEventListener('submit', function (event) {
            event.preventDefault();

            const feedback = document.getElementById('feedback').value.trim();
            const revieweeId = document.getElementById('reviewee-id').value;

            if (selectedRating === 0 || feedback === "") {
                alert('Please provide a rating and feedback.');
                return;
            }

            // Send review data via POST request
            fetch('review_box.php', { // Same file, hence review_box.php
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `rating=${selectedRating}&feedback=${encodeURIComponent(feedback)}&reviewee_id=${revieweeId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Review submitted successfully!');
                } else {
                    alert('Error submitting review: ' + data.message);
                }
            });
        });
    </script>
</body>
</html>
