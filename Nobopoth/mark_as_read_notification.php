<?php
session_start();
include("db_connect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
}
if (isset($_GET['action']) && isset($_GET['application_id'])) {
    $action = $_GET['action']; // "accept" or "reject"
    $application_id = $_GET['application_id'];

    // Fetch the job_id for the given application
    $sqlJobId = "SELECT j_id FROM take_job JOIN notifications ON take_job.j_id = notification.job_id WHERE notification.notificaton_id = ? AND take_job.apply_status = 'pending'";
    $stmtJobId = $conn->prepare($sqlJobId);
    $stmtJobId->bind_param("i", $application_id);
    $stmtJobId->execute();
    $resultJobId = $stmtJobId->get_result();
    $application = $resultJobId->fetch_assoc();

    if ($application) {
        $job_id = $application['j_id'];

        if ($action === 'accept') {
            // Step 1: Accept the selected application
            $sqlAccept = "UPDATE take_job SET apply_status = 'Accepted' JOIN notifications ON take_job.j_id = notification.job_id WHERE notification.notificaton_id = ? AND take_job.apply_status = 'pending'";
            $stmtAccept = $conn->prepare($sqlAccept);
            $stmtAccept->bind_param("i", $application_id);
            $stmtAccept->execute();

            $sqlRejectOthers = "UPDATE take_job SET apply_status = 'Rejected' JOIN notifications ON take_job.j_id = notification.job_id WHERE notification.notificaton_id != ? AND take_job.apply_status = 'pending'";
            $stmtRejectOthers = $conn->prepare($sqlRejectOthers);
            $stmtRejectOthers = $conn->prepare($sqlRejectOthers);
            $stmtRejectOthers->bind_param("ii", $job_id, $application_id);
            $stmtRejectOthers->execute();

            $sqlj= "UPDATE job_tb SET j_status = 'Assigned' WHERE job_id = ?";
            $stmtj = $conn->prepare($sqlj);
            $stmtj->bind_param("i", $job_id);
            $stmtj->execute();

            echo "Application accepted and others rejected successfully!";
        } elseif ($action === 'reject') {
            // Step 3: Reject the selected application
            $sqlReject = "UPDATE take_job SET apply_status = 'Rejected'  JOIN notifications ON take_job.j_id = notification.job_id WHERE notification.notificaton_id = ? AND take_job.apply_status = 'pending'";
            $stmtReject = $conn->prepare($sqlReject);
            $stmtReject->bind_param("i", $application_id);
            $stmtReject->execute();

            echo "Application rejected successfully!";
        }
    } else {
        echo "Invalid application ID.";
    }

    // Close statements
    $stmtJobId->close();
    $stmtAccept->close();
    if (isset($stmtRejectOthers)) $stmtRejectOthers->close();
    if (isset($stmtReject)) $stmtReject->close();
}

$conn->close();

?>