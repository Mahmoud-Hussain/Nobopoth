<?php
session_start();
include("db_connect.php");
if(isset($_POST["filter"]))
 {
    $salary = $_POST["salary"];
    $location = $_POST["location"];
    $order = $_POST["order"];
    if($order == "asc")
    {
        $sql = "SELECT * FROM jobs_tb WHERE salary = ? OR location = ? ORDER BY salary ASC";
    }
    else
    {
        $sql = "SELECT * FROM jobs_tb WHERE salary = ? OR location = ? ORDER BY salary DESC";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $salary, $location);
    $stmt->execute();
    $jobs = $stmt->get_result();
    if($jobs->num_rows > 0)
    {
        while($row = $jobs->fetch_assoc())
        {
            echo "<div class='card'>
            <div class='card-body'>
                <h5 class='card-title'>".$row['job_title']."</h5>"
                . "<form method='post' action='' style='display: inline;'>"
                . "<input type='hidden' name='id' value='" . $row['job_id'] . "'>"
                . "<input type='submit' name='apply' value='apply'>"
                . "</form>";
        }
    }
 }
?>