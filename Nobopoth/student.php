<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard - Nobopoth</title>
    <link rel="stylesheet" href="student.css" />
    <link rel="Icon" href="image/logo.png" type="image/x-icon">
  </head>
  <body>
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"
        >&times;</a
      >
      <a href="student.php">Dashboard</a>
      <a href="#">Orders</a>
      <a href="page.php?type=job">Jobs</a>
      <a href="#">Earnings</a>
      <a href="chat_handler.php">Messages</a>
      <a href="#">Settings</a>
      <a href="signout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </div>
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
    

      <!-- Main Content -->
      <main class="main-content">
        <header class="topbar">
          <div class="welcome">Welcome, [Student's Name]</div>
          <div class="notifications">
            <span class="icon">🔔</span>
            <span class="icon">📧</span>
          </div>
        </header>

        <section class="dashboard-section">
          <h1>Dashboard Overview</h1>
          <div class="cards">
            <div class="card">
              <h2>Total Orders</h2>
              <p>45</p>
            </div>
            <div class="card">
              <h2>Pending Orders</h2>
              <p>5</p>
            </div>
            <div class="card">
              <h2>Earnings</h2>
              <p>$2,300</p>
            </div>
          </div>
        </section>
      </main>
    </div>
    <script>
        function openNav() {
          document.getElementById("mySidenav").style.width = "250px";
          document.getElementById("main").style.marginLeft = "250px";
          document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
        }
        
        function closeNav() {
          document.getElementById("mySidenav").style.width = "0";
          document.getElementById("main").style.marginLeft= "0";
          document.body.style.backgroundColor = "white";
        }
        </script>
        
  </body>
</html>
