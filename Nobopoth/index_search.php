<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - Nobopoth</title>
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
include("db_connect.php");
if($_SESSION["category_id"] === 1 || (isset($_GET['category_id']) && $_GET['category_id'] === 1)){
    $sql = "SELECT * FROM jobs_tb WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$_SESSION["category_id"]);
        $stmt->execute();
        $jobs = $stmt->get_result();
        if($jobs->num_rows > 0)
        {
            while($row = $jobs->fetch_assoc())
            {
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
        }
if(isset($_POST['apply']))
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: signin.php");
        exit();
    }
    else{
        $student_id = $_SESSION['user_id'];
        $job_id = $_POST['id'];//in html 'id' is keeping track of the job_id
        $apply_status = "pending";
        $sql = "INSERT INTO take_job (j_id, u_id, apply_status ) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $job_id, $student_id, $apply_status);
        if($stmt->execute())
        {
            $sqlEmployer = "SELECT u_id FROM drop_job WHERE job_id = ?";
            $stmtEmployer = $conn->prepare($sqlEmployer);
            $stmtEmployer->bind_param("i", $job_id);
            $stmtEmployer->execute();
            $result = $stmtEmployer->get_result();
            $employer = $result->fetch_assoc();
            $employer_id = $employer['u_id'];
    
            // Step 3: Insert notification for employer
            $message = "A student has applied for your job (Job ID: $job_id).";
            $sqlNotification = "INSERT INTO notifications (employer_id, job_id, student_id, message) VALUES (?, ?, ?, ?)";
            $stmtNotification = $conn->prepare($sqlNotification);
            $stmtNotification->bind_param("iiis", $employer_id, $job_id, $student_id, $message);
            if($stmtNotification->execute())
            {
                echo"Application successful";
            }
            
        }
     else
      {
         echo "Failed to apply";
      }
    }
    
 }
}
elseif($_SESSION["category_id"] === 2 || (isset($_GET['category_id']) && $_GET['category_id'] === 2)){
    $sql = "SELECT * FROM jobs_tb WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$_SESSION["category_id"]);
        $stmt->execute();
        $jobs = $stmt->get_result();
        if($jobs->num_rows > 0)
        {
            while($row = $jobs->fetch_assoc())
            {
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
}
if(isset($_POST['apply']))
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: signin.php");
        exit();
    }
    else{
        $student_id = $_SESSION['user_id'];
        $job_id = $_POST['id'];//in html 'id' is keeping track of the job_id
        $apply_status = "pending";
        $sql = "INSERT INTO take_job (j_id, u_id, apply_status ) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $job_id, $student_id, $apply_status);
        if($stmt->execute())
        {
            $sqlEmployer = "SELECT u_id FROM drop_job WHERE job_id = ?";
            $stmtEmployer = $conn->prepare($sqlEmployer);
            $stmtEmployer->bind_param("i", $job_id);
            $stmtEmployer->execute();
            $result = $stmtEmployer->get_result();
            $employer = $result->fetch_assoc();
            $employer_id = $employer['u_id'];
    
            // Step 3: Insert notification for employer
            $message = "A student has applied for your job (Job ID: $job_id).";
            $sqlNotification = "INSERT INTO notifications (employer_id, job_id, student_id, message) VALUES (?, ?, ?, ?)";
            $stmtNotification = $conn->prepare($sqlNotification);
            $stmtNotification->bind_param("iiis", $employer_id, $job_id, $student_id, $message);
            if($stmtNotification->execute())
            {
                echo"Application successful";
            }
            
        }
     else
      {
         echo "Failed to apply";
      }
    }
    
}
}
elseif($_SESSION["category_id"] === 3 || (isset($_GET['category_id']) && $_GET['category_id'] === 3)){
    $sql = "SELECT * FROM jobs_tb WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$_SESSION["category_id"]);
        $stmt->execute();
        $jobs = $stmt->get_result();
        if($jobs->num_rows > 0)
        {
            while($row = $jobs->fetch_assoc())
            {
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
}
if(isset($_POST['apply']))
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: signin.php");
        exit();
    }
    else{
        $student_id = $_SESSION['user_id'];
        $job_id = $_POST['id'];//in html 'id' is keeping track of the job_id
        $apply_status = "pending";
        $sql = "INSERT INTO take_job (j_id, u_id, apply_status ) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $job_id, $student_id, $apply_status);
        if($stmt->execute())
        {
            $sqlEmployer = "SELECT u_id FROM drop_job WHERE job_id = ?";
            $stmtEmployer = $conn->prepare($sqlEmployer);
            $stmtEmployer->bind_param("i", $job_id);
            $stmtEmployer->execute();
            $result = $stmtEmployer->get_result();
            $employer = $result->fetch_assoc();
            $employer_id = $employer['u_id'];
    
            // Step 3: Insert notification for employer
            $message = "A student has applied for your job (Job ID: $job_id).";
            $sqlNotification = "INSERT INTO notifications (employer_id, job_id, student_id, message) VALUES (?, ?, ?, ?)";
            $stmtNotification = $conn->prepare($sqlNotification);
            $stmtNotification->bind_param("iiis", $employer_id, $job_id, $student_id, $message);
            if($stmtNotification->execute())
            {
                echo"Application successful";
            }
            
        }
     else
      {
         echo "Failed to apply";
      }
    }
    
}
}
elseif($_SESSION["category_id"] === 4 || (isset($_GET['category_id']) && $_GET['category_id'] === 4)){
    $sql = "SELECT * FROM jobs_tb WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$_SESSION["category_id"]);
        $stmt->execute();
        $jobs = $stmt->get_result();
        if($jobs->num_rows > 0)
        {
            while($row = $jobs->fetch_assoc())
            {
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
}
if(isset($_POST['apply']))
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: signin.php");
        exit();
    }
    else{
        $student_id = $_SESSION['user_id'];
        $job_id = $_POST['id'];//in html 'id' is keeping track of the job_id
        $apply_status = "pending";
        $sql = "INSERT INTO take_job (j_id, u_id, apply_status ) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $job_id, $student_id, $apply_status);
        if($stmt->execute())
        {
            $sqlEmployer = "SELECT u_id FROM drop_job WHERE job_id = ?";
            $stmtEmployer = $conn->prepare($sqlEmployer);
            $stmtEmployer->bind_param("i", $job_id);
            $stmtEmployer->execute();
            $result = $stmtEmployer->get_result();
            $employer = $result->fetch_assoc();
            $employer_id = $employer['u_id'];
    
            // Step 3: Insert notification for employer
            $message = "A student has applied for your job (Job ID: $job_id).";
            $sqlNotification = "INSERT INTO notifications (employer_id, job_id, student_id, message) VALUES (?, ?, ?, ?)";
            $stmtNotification = $conn->prepare($sqlNotification);
            $stmtNotification->bind_param("iiis", $employer_id, $job_id, $student_id, $message);
            if($stmtNotification->execute())
            {
                echo"Application successful";
            }
            
        }
     else
      {
         echo "Failed to apply";
      }
    }
    
}
}
elseif($_SESSION["category_id"] === 5 || (isset($_GET['category_id']) && $_GET['category_id'] === 5)){
    $sql = "SELECT * FROM jobs_tb WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$_SESSION["category_id"]);
        $stmt->execute();
        $jobs = $stmt->get_result();
        if($jobs->num_rows > 0)
        {
            while($row = $jobs->fetch_assoc())
            {
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
}
if(isset($_POST['apply']))
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: signin.php");
        exit();
    }
    else{
        $student_id = $_SESSION['user_id'];
        $job_id = $_POST['id'];//in html 'id' is keeping track of the job_id
        $apply_status = "pending";
        $sql = "INSERT INTO take_job (j_id, u_id, apply_status ) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $job_id, $student_id, $apply_status);
        if($stmt->execute())
        {
            $sqlEmployer = "SELECT u_id FROM drop_job WHERE job_id = ?";
            $stmtEmployer = $conn->prepare($sqlEmployer);
            $stmtEmployer->bind_param("i", $job_id);
            $stmtEmployer->execute();
            $result = $stmtEmployer->get_result();
            $employer = $result->fetch_assoc();
            $employer_id = $employer['u_id'];
    
            // Step 3: Insert notification for employer
            $message = "A student has applied for your job (Job ID: $job_id).";
            $sqlNotification = "INSERT INTO notifications (employer_id, job_id, student_id, message) VALUES (?, ?, ?, ?)";
            $stmtNotification = $conn->prepare($sqlNotification);
            $stmtNotification->bind_param("iiis", $employer_id, $job_id, $student_id, $message);
            if($stmtNotification->execute())
            {
                echo"Application successful";
            }
            
        }
     else
      {
         echo "Failed to apply";
      }
    }
    
}
}
else{
    echo "No category selected";
}
if(isset($_GET['job_id']) && isset($_GET['type']) && $_GET['type'] === 'apply'){
    $job_id = $_GET['job_id'];
    $student_id = $_SESSION['user_id'];
    $apply_status = "pending";
    $sql = "INSERT INTO take_job (j_id, u_id, apply_status ) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $job_id, $student_id, $apply_status);
    if($stmt->execute())
    {
        $sqlEmployer = "SELECT u_id FROM drop_job WHERE job_id = ?";
        $stmtEmployer = $conn->prepare($sqlEmployer);
        $stmtEmployer->bind_param("i", $job_id);
        $stmtEmployer->execute();
        $result = $stmtEmployer->get_result();
        $employer = $result->fetch_assoc();
        $employer_id = $employer['u_id'];

        // Step 3: Insert notification for employer
        $message = "A student has applied for your job (Job ID: $job_id).";
        $sqlNotification = "INSERT INTO notifications (employer_id, job_id, student_id, message) VALUES (?, ?, ?, ?)";
        $stmtNotification = $conn->prepare($sqlNotification);
        $stmtNotification->bind_param("iiis", $employer_id, $job_id, $student_id, $message);
        if($stmtNotification->execute())
        {
            echo"Application successful";
        }
        
    }
 else
  {
     echo "Failed to apply";
  }
}

?> 
   <footer class="footer">
        <div class="container">   
            <p>&copy; 2025 Nobopoth. All rights reserved.</p>
        </div>
    </footer>   
</body>
</html> 