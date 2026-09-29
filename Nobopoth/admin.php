<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Nobopoth</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="icon" href="image/logo.png" type="image/x-icon">
</head>
<body>
  <!-- Sidebar Navigation -->
  <div id="adminSidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="admin.php">Dashboard</a>
    <ul class="category-list">
    <li>Categories</li>
    <li><h5><a href="index_search.php?category_id=1"> Web Development</a></h5></li>
    <li><h5><a href="index_search.php?category_id=2">Graphic Design</a></h5></li>
    <li><h5><a href="index_search.php?category_id=3">Digital Marketing</a></h5></li>
    <li><h5><a href="index_search.php?category_id=4">Writing & Translation</a></h5></li>
    <li><h5><a href="index_search.php?category_id=5">Video & Animation</a></h5></li>
    </ul> 
    <a href="page.php?type=job">Jobs</a>
    <a href="#">Reviews</a>
    <a href="chat_handler.php">Chatbox</a>
    <a href="page.php?type=student">Enrolled Students</a>
    <a href="signout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
  </div>
  
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Top Bar -->
    <!-- Logo Outside the Header -->
    <div class="topbar-logo">
    <img src="image/logo.png" alt="Nobopoth Logo" style="height:50px;">
    </div>

    <!-- Main Header Content -->
    <header class="topbar">
    <div class="welcome">Welcome, [Admin's Name]</div> <!-- Welcome text inside the header -->
    <div class="notifications">
       <span class="icon">🔔</span>
       <span class="icon">📧</span>
    </div>
</header>

    <!-- Dashboard Overview -->
    <section class="dashboard-section">
      <h1>Admin Dashboard Overview</h1>
      <div class="cards">
        <div class="card">
          <h2>Total Posted Jobs</h2>
          <p>10</p>
        </div>
        <div class="card">
          <h2>Pending Orders</h2>
          <p>20</p>
        </div>
        <div class="card">
          <h2>Total Done Jobs</h2>
          <p>10</p>
        </div>
      </div>
    </section>

    <!-- Applied Requests Section -->
    <section class="requests-section">
      <h2>Applied Requests</h2>
      <div class="requests">
        <p>No requests at the moment.</p>
      </div>
    </section>

    <!-- Modals -->
    <!-- Review Modal -->
    <div id="reviewModal" class="modal">
      <div class="modal-content">
        <span class="close" id="closeReview">&times;</span>
        <h2>Reviews Section</h2>
        <p>Here you can view and add reviews.</p>
      </div>
    </div>

    <!-- Chatbot Modal -->
    <div id="chatbotBox" class="modal">
      <div class="modal-content">
        <span class="close" id="closeChatbot">&times;</span>
        <h2>Chat with AI</h2>
        <div id="chatbotContainer">
          <!-- Chatbot interface goes here -->
        </div>
        <div class="chatbot-input">
          <input type="text" id="chatInput" placeholder="Type a message...">
          <button id="sendChat">Send</button>
        </div>
      </div>
    </div>

    <!-- Enrolled Students Modal -->
    <div id="studentBox" class="modal">
      <div class="modal-content">
        <span class="close" id="closeStudent">&times;</span>
        <h2>Enrolled Students</h2>
        <div id="studentContainer">
          <p>No students enrolled yet.</p>
        </div>
      </div>
    </div>
  </main>

  <script>
    function openNav() {
      document.getElementById("adminSidenav").style.width = "250px";
      document.body.style.marginLeft = "250px";
      document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    function closeNav() {
      document.getElementById("adminSidenav").style.width = "0";
      document.body.style.marginLeft = "0";
      document.body.style.backgroundColor = "white";
    }
  </script>
</body>
</html>
