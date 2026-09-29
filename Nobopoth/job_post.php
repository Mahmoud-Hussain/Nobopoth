<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['employer_id'])) {
    echo "You must be logged in to post a job.";
    header("Location: signin.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["post"])) {
    
        $jobTitle = $_POST["jobtitle"];
        $jobDescription = $_POST["jobdescription"];
        $jobSalary = $_POST["salary"];
        $duration = $_POST["duration"];
        $location = $_POST["location"];
        $categoryId = $_POST["category"];
        $jobStatus = $_POST["jobstatus"];

        
        if (empty($jobTitle) || empty($jobDescription) || empty($jobSalary) || empty($startTime) || empty($location) || empty($categoryId)) {
            echo "Please fill in all required fields.";
            exit();
        }

        
        $employerId = $_SESSION['user_id'];
        $sql = "INSERT INTO jobs_tb (job_title, j_description, salary,  location, category_id, j_status, duration)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsiss', $jobTitle, $jobDescription, $jobSalary, $location, $categoryId, $jobStatus, $duration);
        if ($stmt->execute()) {
            $_SESSION['job_id'] = $stmt->insert_id;
            $jobId= $_SESSION['job_id'];
            $sql_s = "INSERT INTO drop_job (j_id, u_id)
                VALUES (?, ?)";
            $stmt_s = $conn->prepare($sql);
            $stmt_s->bind_param('ii', $jobId, $employerId);
            if ($stmt_s->execute()) {
                echo "Job posted successfully!";
            } else {
                echo "Error posting job: " . $stmt_s->error;
            }
        } else {
            echo "Error posting job: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
