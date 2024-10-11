<?php
session_start();
include 'php/db_connect.php';

// Check if the user is logged in as a job seeker
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'job_seeker') {
    header('Location: job_seeker.php'); // Redirect if not logged in
    exit();
}

// Fetch job postings
$query = "SELECT * FROM job_posts";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Seeker Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Content with padding to avoid overlap -->
    <div class="flex flex-col items-center pt-16"> <!-- Added 'pt-16' for padding-top -->
        <h2 class="text-3xl font-bold mb-8 text-blue-600">Available Job Postings</h2>
        <div class="bg-white p-8 rounded-lg shadow-lg w-3/4 lg:w-2/3">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="border-b border-gray-200 mb-6 pb-4 last:border-b-0">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        <?php 
                            echo htmlspecialchars(isset($row['title']) ? $row['title'] : 'N/A'); 
                        ?>
                    </h3>
                    <p class="text-gray-700 mb-2">
                        <?php 
                            echo htmlspecialchars(!empty($row['description']) ? $row['description'] : 'Description not available.');
                        ?>
                    </p>
                    <p class="text-gray-600 mb-1">
                        <strong>Requirements:</strong> 
                        <?php 
                            echo htmlspecialchars(!empty($row['requirements']) ? $row['requirements'] : 'Requirements not available.');
                        ?>
                    </p>
                    <p class="text-gray-600 mb-1">
                        <strong>Salary:</strong> 
                        <?php 
                            echo htmlspecialchars(!empty($row['salary']) ? $row['salary'] : 'Salary not available.');
                        ?>
                    </p>
                    <p class="text-gray-600 mb-1">
                        <strong>Category:</strong> 
                        <?php 
                            echo htmlspecialchars(!empty($row['category']) ? $row['category'] : 'Category not available.');
                        ?>
                    </p>
                </div>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($result) === 0): ?>
                <p class="text-gray-600">No job postings available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Include the Footer -->
    <?php include 'footer.php'; ?>

</body>
</html>
