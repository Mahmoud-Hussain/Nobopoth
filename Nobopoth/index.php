<?php
session_start();
include("db_connect.php");
if(isset($_POST["search"])){
    $category = $_POST["category"];
    if($category ==="web-development"){
        $categoryId = 1;
        $_SESSION["category_id"] = $categoryId;
        header("Location: index_search.php");
    }
    elseif($category ==="graphic-design"){
        $categoryId = 2;
        $_SESSION["category_id"] = $categoryId;
        header("Location: index_search.php");
    }
    elseif($category ==="digital-marketing"){
        $categoryId = 3;
        $_SESSION["category_id"] = $categoryId;
        header("Location: index_search.php");
    }
    elseif($category ==="writing-translation"){
        $categoryId = 4;
        $_SESSION["category_id"] = $categoryId;
        header("Location: index_search.php");
    }
    elseif($category ==="video-animation"){
        $categoryId = 5;
        $_SESSION["category_id"] = $categoryId;
        header("Location: index_search.php");
    }
    else{
        echo "No category selected";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nobopoth - Discover Your Needs</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="Icon" href="image/logo.png" type="image/x-icon">

</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <div>
                    <img src="image/logo.png" alt="Nobopoth Logo">
                    <span>Nobopoth</span>
                </div>
                <div class="auth-container">
                    <a href="signin.php" class="nav-link">Sign In</a>
                    <a href="signup.php" class="nav-link">Sign Up</a>
                </div>
            </div>
            <nav class="nav">
                <a href="#" class="nav-link">Home</a>
                <a href="#categories" class="nav-link">Categories</a>
                <a href="#how-it-works" class="nav-link">How It Works</a>
                <a href="#testimonials" class="nav-link">Testimonials</a>
                <a href="#contact" class="nav-link">Contact</a>
            </nav>
        </div>
    </header>
    
    <section class="hero" style="background-image: url('image/main.jpeg'); background-size: cover; background-position: center;">
        <div class="container">
            <h1 class="fade-in">Find the Perfect Service for Your Needs</h1>
            <form class="search-bar slide-in" action="" method="POST">
                <select name="category" class="category-dropdown">
                    <option value="">All Categories</option>
                    <option value="web-development" name="web-development">Web Development</option>
                    <option value="graphic-design" name="graphic-design">Graphic Design</option>
                    <option value="digital-marketing" name="digital-marketing">Digital Marketing</option>
                    <option value="writing-translation" name="writing-translation">Writing & Translation</option>
                    <option value="video-animation" name="video-animation">Video & Animation</option>
                </select>
                <input type="text" name="query" placeholder="What service are you looking for?" />
                <button type="submit" name="search"><i class="fas fa-search"></i></button>
            </form>
            <div class="stats">
                <div class="stat-item">
                    <h3>1,500+</h3>
                    <p>Active Users</p>
                </div>
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Categories</p>
                </div>
                <div class="stat-item">
                    <h3>20K+</h3>
                    <p>Monthly Users</p>
                </div>
            </div>
        </div>
    </section>

    <section id="categories" class="categories">
        <div class="container">
            <h2>Explore Categories</h2>
            <div class="category-list">
                <div class="category-item bounce">
                    <img src="image/web_development.jpg" alt="Web Development" style="width: 200px; height: 200px;">
                    <span>Web Development</span>
                </div>
                <div class="category-item bounce">
                    <img src="image/graphics_design-01.jpg" alt="Graphic Design" style="width: 200px; height: 200px;">
                    <span>Graphic Design</span>
                </div>
                <div class="category-item bounce">
                    <img src="image/digital_marketing.jpg" alt="Digital Marketing" style="width: 200px; height: 200px;">
                    <span>Digital Marketing</span>
                </div>
                <div class="category-item bounce">
                    <img src="image/writing and translation.jpg" alt="Writing & Translation" style="width: 200px; height: 200px;">
                    <span>Writing & Translation</span>
                </div>
                <div class="category-item bounce">
                    <img src="image/video editing.png" alt="Video & Animation" style="width: 200px; height: 200px;">
                    <span>Video & Animation</span>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step slide-in">
                    <img src="image/step1.jpg" alt="Step 1" style="width: 200px; height: 200px;">
                    <h3>Step 1</h3>
                    <p>Describe your needs and find the best services.</p>
                </div>
                <div class="step slide-in">
                    <img src="image/step2.jpg" alt="Step 2" style="width: 200px; height: 200px;">
                    <h3>Step 2</h3>
                    <p>Compare prices and select the best offer.</p>
                </div>
                <div class="step slide-in">
                    <img src="image/step3.jpg" alt="Step 3" style="width: 200px; height: 200px;">
                    <h3>Step 3</h3>
                    <p>Get your project done by professionals.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="testimonials">
        <div class="container">
            <h2>Testimonials</h2>
            <div class="testimonial-list">
                <div class="testimonial-item fade-in">
                    <img src="image/user1.jpg" alt="User 1" style="width: 200px; height: 200px;">
                    <p>"Nobopoth helped me find the perfect web developer for my project!"</p>
                    <span>- User 1</span>
                </div>
                <div class="testimonial-item fade-in">
                    <img src="image/user2.jpg" alt="User 2" style="width: 200px; height: 200px;">
                    <p>"Great platform for finding talented freelancers."</p>
                    <span>- User 2</span>
                </div>
                <div class="testimonial-item fade-in">
                    <img src="image/user3.jpg" alt="User 3" style="width: 200px; height: 200px;">
                    <p>"I highly recommend Nobopoth for any service needs."</p>
                    <span>- User 3</span>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">   
            <p>&copy; 2025 Nobopoth. All rights reserved.</p>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>
