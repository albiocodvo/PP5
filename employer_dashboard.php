<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'php/db_connect.php';

// Check if the user is logged in as an employer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employer') {
    header('Location: employer_login.php'); // Redirect if not logged in
    exit();
}

// Check if 'employer_id' is set in the session
if (!isset($_SESSION['employer_id'])) {
    // Optionally, you can destroy the session and redirect to login
    session_destroy();
    header('Location: employer_login.php'); // Redirect to login if employer_id is not set
    exit();
}

// Handle job creation
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $job_title = trim($_POST['job_title']);
    $job_description = trim($_POST['job_description']);
    $requirements = trim($_POST['requirements']);
    $salary = trim($_POST['salary']);
    $category = trim($_POST['category']);
    $employer_id = $_SESSION['employer_id']; // Now guaranteed to be set

    // Validate salary is numeric
    if (!is_numeric($salary)) {
        $message = "Salary must be a numeric value.";
    } else {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO job_posts (employer_id, title, description, requirements, salary, category, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param("isssis", $employer_id, $job_title, $job_description, $requirements, $salary, $category);
            
            if ($stmt->execute()) {
                $message = "Job added successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!-- Optional: for icons -->
</head>
<body class="bg-gray-100">
    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="flex flex-col items-center py-8 mt-16"> <!-- Add margin-top to avoid overlap -->
        <h2 class="text-2xl font-bold mb-4">Employer Dashboard</h2>
        <form method="POST" class="max-w-md w-full bg-white p-6 rounded shadow-md space-y-4">
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="job_title" id="job_title" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="job_title" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0">Job Title</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <textarea name="job_description" id="job_description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required></textarea>
                <label for="job_description" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0">Job Description</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <textarea name="requirements" id="requirements" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required></textarea>
                <label for="requirements" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0">Requirements</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="salary" id="salary" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="salary" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0">Salary</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="category" id="category" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="category" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0">Category</label>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Add Job</button>
            </div>
        </form>
        <?php if ($message): ?>
            <p class="text-green-500 mt-4"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
