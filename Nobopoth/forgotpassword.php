<?php
    session_start();
    include("db_connect.php");

    //Update Password
    if(isset($_POST["update-password"]))
    {
          $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
          $username = $_POST["username"];
          $sql = "SELECT * FROM user_tb WHERE e_mail = ? AND username = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ss", $email, $username);
          $stmt->execute();
          $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $new_pass= $_POST["new_password"];
            $confirm_pass= $_POST["confirm_password"];
            if ($new_pass !== $confirm_pass) {
                echo "Passwords do not match. Please try again.";
                exit;
               }
            else{
                $hashedpassword = password_hash($new_pass, PASSWORD_DEFAULT);
                $sql = "UPDATE user_tb SET u_password=? WHERE e_mail=? AND username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss',$hashedpassword, $email, $username);
           
                if ($stmt->execute()) {
                    echo"Update successful";
                    header("Location: signin.php");
            } else {
                  echo"Update failed. Please try again.";
              }
          $stmt->close();
         }
        }
       }
 $conn->close();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password - Nobopoth</title>
    <link rel="stylesheet" href="forgotpassword.css">
    <link href="https:fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="Icon" href="image/logo.png" type="image/x-icon">
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
                <a href="#" class="nav-link">About page</a>
            </nav>
        </div>
    </header>

    <!-- Update Password Form -->
    <div class="update-password-container">
        <div class="update-password-box">
            <h1>Update Password</h1>
            <form method="post" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required>
                </div>
                <button type="submit" name="update-password" class="btn">Update Password</button>
            </form>
        </div>
    </div>
    
</body>
</html>
