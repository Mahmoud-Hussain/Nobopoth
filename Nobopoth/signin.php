<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Nobopoth</title>
    <link rel="stylesheet" href="signin.css">
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

    <?php
// LOGIN
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["login"])) {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $sql = "SELECT * FROM user_tb WHERE e_mail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Debugging output (only for development, remove in production)
            /*echo "User ID: " . $user["user_id"] . "<br>";
            echo "Name: " . $user["first_name"] . "<br>";
            echo "Email: " . $user["e_mail"] . "<br>";
            echo "User Type: " . $user["user_type"] . "<br>";
            echo "Stored Hash: " . $user["u_password"] . "<br>";*/

            $u_password = $user['u_password'];

            /*echo "u_password: " . $u_password . "<br>";
            echo "password: " . $password . "<br>";
            var_dump(password_verify($password, $u_password));*/

            // Verify the password
            if (password_verify($password, $u_password) === true) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_type'] = $user['user_type'];

                // Redirect based on user type
                switch ($user['user_type']) {
                    case 'student':
                        header("Location: student.php");
                        break;
                    case 'admin':
                        header("Location: admin.php");
                        break;
                    case 'employer':
                        header("Location: employer.php");
                        break;
                    default:
                        echo "Unknown user type.";
                }
                exit();
            } else {
                echo "Invalid password. Please try again.";
            }
        } else {
            echo "No user found with this email.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

    <!-- Sign-In Form -->
    <div class="signin-container">
        <div class="signin-box">
            <h1>Sign In</h1>
            <form method="post" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="login" class="btn">Log In</button>
            </form>
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign up here</a>
            </div>
            <div class="forgot-password">
                <a href="forgotpassword.php">Forgot password?</a>
            </div>
        </div>
    </div>
</body>
</html>
