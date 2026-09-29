<?php
//register
session_start();
include ("db_connect.php") ;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST["register"]))
    {
      $first_name = $_POST["firstname"];
      $last_name = $_POST["lastname"];
      $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
      $username = $_POST["username"];
      $dateofbirth = $_POST["dob"];
      $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_SPECIAL_CHARS);
      $password = $_POST["password"];
      $confirm_password = $_POST["confirm-password"];
      $domain = "uiu.ac.bd";

      //Check pass
      if ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
        exit;
       }
       
       //check type
      if (!in_array($type, ['admin', 'employer', 'student'], true)) {
        echo "Invalid user type selected.";
        exit;
       }
       
       //ensure student
      if ($type === "student") {
        $emailParts = explode("@", $email);
        if (count($emailParts) === 2) {
            $emailDomain = $emailParts[1];
        
            if (substr($emailDomain, -strlen($domain)) !== $domain)
            {echo "Students must use a valid university email (e.g., name@subdomain.uiu.ac.bd).";
            exit;}
         }
       }
     
       //ensure 1 admin per uni
     if ($type === "admin") {
        $sql = "SELECT * FROM user_tb WHERE u_type = 'admin' AND e_mail = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "An admin account with this email already exists.";
            exit;
        }
      }
     
      //ensure 1 admin per portal
     if ($type === "admin") {
        $sql = "SELECT * FROM user_tb WHERE u_type = 'admin'";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "This portal has an admin registered";
            exit;
        }
      }
      // Ensure unique email
    $sql_c = "SELECT * FROM user_tb WHERE e_mail = ?";
    $stmt_c = $conn->prepare($sql_c);
    $stmt_c->bind_param('s', $email);
    $stmt_c->execute();
    $result_c = $stmt_c->get_result();

         if ($result_c->num_rows > 0) {
       echo "Email already exists. Please use a different email.";
      exit;
    }
      //sql
      $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO user_tb (first_name, last_name, e_mail, username, u_password, date_of_birth, user_type)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('sssssss', $first_name, $last_name, $email, $username, $hashedpassword, $dateofbirth, $type);
           
      if ($stmt->execute()) {
            echo"registration successful";


        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_type'] = $type;

        if ($type === "student") {
            header("Location: student.php");
        } elseif ($type === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: employer.php");
        }
        exit();
      } else {
         $error = "Registration failed. Please try again.";
      }
     $stmt->close();
 }
 $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Nobopoth</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="icon" href="image/logo.png" type="image/x-icon">
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
            <!-- Hamburger Menu Icon -->
            <div class="menu-icon" onclick="toggleNav()">&#9776;</div>
            <nav class="nav" id="nav">
                <a href="index.php" class="nav-link">Home</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Sign-Up Form and Image Container -->
        <div class="signup-container">
            <div class="signup-box">
                <h1>Create an Account</h1>
                <p>Join Nobopoth to discover the best services for your needs.</p>
                <form method = "post" action ="">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                     <label for="dob">Date of Birth</label>
                     <input type="date" id="dob" name="dob" placeholder="Enter your date of birth" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Type</label>
                        <select id="role" name="type" required>
                            <option value="">Select your type</option>
                            <option value="admin">Admin</option>
                            <option value="employer">Employer</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Create a password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" name="register" class="btn">Sign Up</button>
                </form>
                <div class="signin-link">
                    Already have an account? <a href="signin.php">Sign in here</a>
                </div>
            </div>
            <!-- Right Aligned Image -->
            <div class="signup-image-container">
                <img src="image/signup.jpg" alt="Sign Up Image" class="signup-image">
            </div>
        </div>
    </div>
   <!-- JavaScript for Hamburger Menu -->
     <script>
        function toggleNav() {
            const nav = document.getElementById('nav');
            nav.classList.toggle('active');
        }
    </script>
</body>
</html>
