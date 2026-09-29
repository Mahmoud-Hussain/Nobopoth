<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nobopoth</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="image/logo.png" alt="Nobopoth Logo">
                    <span>Nobopoth</span>
                </a>
            </div>
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="#" class="nav-link">About</a>
            </nav>
        </div>
    </header>
<?php
session_start();
include('db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
if($_SESSION['user_type'] = 'admin'){
    // Get the type parameter from the URL
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Display content based on the type parameter
if ($type == 'job') {
    // Fetch and display jobs
    $sql = "SELECT * FROM jobs_tb";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "
<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
    <table style='border-collapse: collapse; width: 50%; text-align: center;'>
        <thead>
            <tr style='background-color:rgb(155, 150, 150);'>
                <th style='border: 1px solid #000000; padding: 8px;'>Job Title</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style='border: 1px solid #000000; padding: 8px;'>".$row['job_title']."</td>
                <td style='border: 1px solid #000000; padding: 8px;'>
                    <form method='post' action='' style='display: inline;'>
                        <input type='hidden' name='id' value='" . $row['job_id'] . "'>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>";
    }
    
} elseif ($type == 'student') {
    // Fetch and display enrolled students
    $sql = "SELECT * FROM user_tb WHERE e_mail LIKE '%uiu.ac.bd' AND user_type = 'Student'"; // Adjust the table name and columns as needed
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "
<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
    <table style='border-collapse: collapse; width: 50%; text-align: center;'>
        <thead>
            <tr style='background-color:rgb(155, 150, 150);'>
                <th style='border: 1px solid #000000; padding: 8px;'>NAME</th>
                <th style='border: 1px solid #000000; padding: 8px;'>EMAIL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style='border: 1px solid #000000; padding: 8px;'>".$row['first_name']." ".$row['last_name']."</td>
                    <form method='post' action='' style='display: inline;'>
                        <input type='hidden' name='id' value='" . $row['user_id'] . "'>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>";
    }
    
} else {
    echo "<h1>Invalid type specified.</h1>";
}
}
if($_SESSION['user_type'] = 'employer'){
    // Get the type parameter from the URL
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    // Display content based on the type parameter
    if ($type == 'job') {
        // Fetch and display jobs
        $sql = "SELECT * FROM jobs_tb";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "
    <div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
        <table style='border-collapse: collapse; width: 50%; text-align: center;'>
            <thead>
                <tr style='background-color:rgb(155, 150, 150);'>
                    <th style='border: 1px solid #000000; padding: 8px;'>Job Title</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='border: 1px solid #000000; padding: 8px;'>".$row['job_title']."</td>
                        <form method='post' action='' style='display: inline;'>
                            <input type='hidden' name='id' value='" . $row['job_id'] . "'>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>";
        }
     
}
}
if($_SESSION['user_type'] = 'student'){
        // Get the type parameter from the URL
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Display content based on the type parameter
if ($type == 'job') {
    // Fetch and display jobs
    $sql = "SELECT * FROM jobs_tb";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "
<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
    <table style='border-collapse: collapse; width: 50%; text-align: center;'>
        <thead>
            <tr style='background-color:rgb(155, 150, 150);'>
                <th style='border: 1px solid #000000; padding: 8px;'>Job Title</th>
                <th style='border: 1px solid #000000; padding: 8px;'>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style='border: 1px solid #000000; padding: 8px;'>".$row['job_title']."</td>
                <td style='border: 1px solid #000000; padding: 8px;'>
                    <form method='post' action='' style='display: inline;'>
                        <input type='hidden' name='id' value='" . $row['job_id'] . "'>
                        <input type='submit' name='apply' value='Apply' 
                        style='background-color:rgb(211, 115, 20); color: white; border: none; padding: 8px 16px; cursor: pointer;'>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>";
    }
if(isset($_POST['apply'])){
    header("Location: index_search.php?job_id=".$row['job_id']."&type=apply");
}
}
}
$conn->close();
?>