<?php
session_start();
include("db_connect.php");

// Ensure the user is logged in and is either Admin or Employer
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_type'], ['admin', 'employer'])) {
    header("Location: signin.php");
    exit;
}

// Variables to store fetched IDs and amount
$student_id = null;
$job_id = null;
$salary = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_name'], $_POST['job_title'], $_POST['job_salary'])) {
    $student_name = $_POST['student_name'];
    $job_title = $_POST['job_title'];
    $salary = $_POST['job_salary'];

    // Fetch student_id and job_id based on inputs
    $sql = "SELECT 
                u.user_id AS student_id, 
                j.job_id 
            FROM 
                user_tb u
            JOIN 
                take_job tj ON u.user_id = tj.u_id
            JOIN 
                jobs_tb j ON tj.j_id = j.job_id
            WHERE 
                CONCAT(u.first_name, ' ', u.last_name) = ? 
                AND j.job_title = ? 
                AND j.salary = ? 
                AND tj.apply_status = 'Accepted'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $student_name, $job_title, $salary);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $student_id = $row['student_id'];
        $job_id = $row['job_id'];
    } else {
        echo "Error: No matching job or student found!";
        exit;
    }
}

// After successful payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_status']) && $_POST['payment_status'] === 'success') {
    $payment_data = json_decode($_POST['payment_data'], true);
    $amount = $payment_data['amount'];
    $payedby_id = $_SESSION['user_id']; // Admin/Employer ID
    $payedto_id = $student_id;

    // Insert payment record
    $sql = "INSERT INTO payment_tb (j_id, payedto_id, payedby_id, amount) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $job_id, $payedto_id, $payedby_id, $amount);
    if ($stmt->execute()) {
        echo "Payment record saved successfully!";
    } else {
        echo "Error saving payment record: " . $stmt->error;
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
    <title>Payment via bKash</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Payment Form</h2>
    <form id="payment-form">
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" required><br>

        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title" required><br>

        <label for="job_salary">Job Salary:</label>
        <input type="number" id="job_salary" name="job_salary" required><br>

        <button type="button" id="proceed-payment">Proceed to Payment</button>
    </form>

    <script>
        // Handle payment form submission
        $('#proceed-payment').click(function () {
            const studentName = $('#student_name').val();
            const jobTitle = $('#job_title').val();
            const jobSalary = $('#job_salary').val();

            // Validate input
            if (!studentName || !jobTitle || !jobSalary) {
                alert("Please fill all fields.");
                return;
            }

            // Fetch student_id and job_id
            $.ajax({
                url: "payment.php", // Current file
                type: "POST",
                data: { student_name: studentName, job_title: jobTitle, job_salary: jobSalary },
                success: function (response) {
                    // Assuming response includes success message or redirect to SSLCommerz
                    console.log(response);

                    // Redirect to SSLCommerz for payment
                    const paymentData = {
                        student_name: studentName,
                        job_title: jobTitle,
                        amount: jobSalary,
                    };

                    // For demonstration, redirecting to a test URL
                    const sslCommerzURL = `https://sandbox.sslcommerz.com/gwprocess/v4/api.php`;
                    window.location.href = sslCommerzURL + "?" + $.param(paymentData);
                },
                error: function (error) {
                    console.error("Error fetching payment details:", error);
                }
            });
        });

        // After payment redirection back
        const queryParams = new URLSearchParams(window.location.search);
        if (queryParams.get('payment_status') === 'success') {
            const paymentData = {
                payment_status: 'success',
                payment_data: JSON.stringify({
                    amount: queryParams.get('amount'),
                }),
            };

            // Save payment record
            $.post('payment.php', paymentData, function (response) {
                alert(response);
            });
        }
    </script>
</body>
</html>
