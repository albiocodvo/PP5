<?php
session_start();
include 'php/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    
    // Insert job post into database
    $query = "INSERT INTO job_posts (job_title, company_name, job_description, location, salary) VALUES ('$job_title', '$company_name', '$job_description', '$location', '$salary')";
    
    if (mysqli_query($conn, $query)) {
        $message = "Job post added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Job Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <section class="bg-gray-50 dark:bg-gray-900 py-16">
        <div class="max-w-screen-xl mx-auto p-6 bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Add Job Post</h2>
            <?php if ($message): ?>
                <div class="mb-4 text-green-500 text-center"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST" class="space-y-6">
                <div>
                    <label for="job_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Job Title</label>
                    <input type="text" name="job_title" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter job title" />
                </div>
                <div>
                    <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                    <input type="text" name="company_name" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter company name" />
                </div>
                <div>
                    <label for="job_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Job Description</label>
                    <textarea name="job_description" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter job description"></textarea>
                </div>
                <div>
                    <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                    <input type="text" name="location" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter job location" />
                </div>
                <div>
                    <label for="salary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary</label>
                    <input type="text" name="salary" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter salary" />
                </div>
                <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700">Add Job Post</button>
            </form>
        </div>
    </section>
</body>
</html>
