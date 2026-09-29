<?php
session_start();
include("db_connect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
}
$sql = "SELECT j_id FROM take_job WHERE apply_status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$job_id = $row['j_id'];//fetching job id that has been applied by a student


$sqlE = "SELECT u_id FROM drop_job WHERE j_id = ?";
$stmtE = $conn->prepare($sqlE);
$stmtE->bind_param("i", $job_id);
$stmtE->execute();
$resultE = $stmtE->get_result();
$rowE = $resultE->fetch_assoc();
$employer_id = $rowE['u_id'];//fetching employer id who posted the job

$sqlN = "SELECT n.notification_id, n.message, n.status, n.created_at, u.name AS student_name, j.job_title
        FROM notifications n
        JOIN user_tb u ON n.student_id = u.user_id
        JOIN jobs_tb j ON n.job_id = j.job_id
        WHERE n.employer_id = ?
        ORDER BY n.created_at DESC";
$stmtN = $conn->prepare($sqlN);
$stmtN->bind_param("i", $employer_id);
$stmtN->execute();
$resultN = $stmtN->get_result();
while($rowN = $resultN->fetch_assoc())
{
    echo "Notification: " . $rowN['message'] . "<br>";
        echo "Student Name: " . $rowN['student_name'] . "<br>";
        echo "Job Title: " . $rowN['job_title'] . "<br>";
        echo "Status: " . $rowN['status'] . "<br>";
        echo "Created At: " . $rowN['created_at'] . "<br>";
        echo "<a href='mark_as_read_notification.php?id=" . $rowN['notification_id'] . "'>Mark as Read</a><br><br>";
}

?>
