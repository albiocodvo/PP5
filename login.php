<?php
session_start();
include 'php/db_connect.php';

$message = '';
$role = ''; // Initialize $role to an empty string

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['role']) && isset($_POST['username']) && isset($_POST['password'])) {
        // Handle login
        $role = $_POST['role'];
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];

        if ($role === 'employer') {
            // Check employer in the database using username
            $query = "SELECT * FROM employers WHERE username='$username'";
        } else {
            // Check job seeker in the database
            $query = "SELECT * FROM users WHERE username='$username'";
        }

        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        // Verify password and set session variables
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $role; // Store role in session
            header('Location: index.php');
            exit();
        } else {
            $message = "Invalid credentials.";
        }
    } elseif (isset($_POST['role_select'])) {
        // Handle role selection
        $role = $_POST['role_select'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Job Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Basic styling for the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px; /* Location of the box */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 5% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 500px;
            border-radius: 8px;
            position: relative; /* Add this for positioning the close button */
        }
        .close {
            position: absolute; /* Position the close button */
            top: 10px; /* Position it at the top */
            right: 15px; /* Position it on the right */
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
        /* Button styles */
        .role-button {
            width: calc(100% - 0.5rem); /* Full width minus some margin */
            padding: 1rem; /* Increase padding for a larger button */
            font-size: 1rem; /* Increase font size */
            border-radius: 0.375rem; /* Match rounded corners */
            transition: background-color 0.2s; /* Smooth transition */
        }
        .role-button:hover {
            background-color: #4b8fd8; /* Slightly lighter on hover */
        }
    </style>
</head>
<body class="bg-gray-100" <?php if ($role === '') { echo 'onload="showModal()"'; } ?>>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <?php if ($role === ''): ?>
        <!-- Role Selection Modal -->
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="roleModal">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <span class="close" onclick="location.href='landing_page.php'">&times;</span> <!-- Close button -->
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Select Your Role</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Are you an Employer or a Job Seeker?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-x-3"> <!-- Added gap-x-3 for space -->
                            <form method="POST" action="employer_login.php" class="sm:w-full">
                                <button type="submit" name="role_select" value="employer" class="role-button w-full bg-blue-600 text-white shadow-sm hover:bg-blue-500">Employer</button>
                            </form>
                            <form method="POST" action="job_seeker.php" class="mt-3 sm:mt-0 sm:w-full">
                                <button type="submit" name="role_select" value="job_seeker" class="role-button w-full bg-blue-600 text-white shadow-sm hover:bg-blue-500">Job Seeker</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Login Form -->
        <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Login as</h2>
            <?php if ($message): ?>
                <p class="text-red-500 mb-4"><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                    Login as <?php echo ucfirst(str_replace('_', ' ', $role)); ?>
                </button>
            </form>
        </div>
    <?php endif; ?>
</body>
<script>
    // Function to show the modal
    function showModal() {
        document.getElementById("roleModal").style.display = "block";
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById("roleModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</html>
