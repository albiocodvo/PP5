<?php
session_start();
include 'php/db_connect.php';

$message = ''; // Initialize message variable
$redirect_url = ''; // Initialize redirect URL variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = mysqli_real_escape_string($conn, $_POST['role']); // Get the selected role

    // Insert new user into the database
    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

    if (mysqli_query($conn, $query)) {
        $message = "User created successfully.";
        // Set redirect URL based on the role
        $redirect_url = ($role === 'job_seeker') ? 'job_seeker.php' : 'employer_login.php';
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to open modal and redirect after a delay
        function showModalAndRedirect(message, redirectUrl) {
            const modal = document.getElementById('successModal');
            const modalMessage = document.getElementById('modalMessage');
            modalMessage.textContent = message; // Set message in modal
            modal.classList.remove('hidden'); // Show modal

            setTimeout(() => {
                window.location.href = redirectUrl; // Redirect after 3 seconds
            }, 3000); // 3000 milliseconds = 3 seconds
        }
        
        function redirectToLogin() {
            window.location.href = 'employer_login.php'; // Redirect to login page
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto" src="./assets/images/tvac-logo-1.png" alt="The Virtual Aid Co. Logo" style="height: 170px; width: auto;">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create Your Account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <?php if ($message): ?>
                <script>
                    window.onload = function() {
                        showModalAndRedirect("<?php echo $message; ?>", "<?php echo $redirect_url; ?>");
                    }
                </script>
            <?php endif; ?>
            <!-- Bordered container -->
            <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-lg">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" style="width: 300px;">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" style="width: 300px;">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" style="width: 300px;">
                        </div>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium leading-6 text-gray-900">I am a:</label>
                        <select name="role" required class="block w-full mt-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="">Select Role</option>
                            <option value="job_seeker">Job Seeker</option>
                            <option value="employer">Employer</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create Account</button>
                    </div>
                </form>
            </div>
            <!-- Back to Login Button -->
            <div class="mt-4">
                <button onclick="redirectToLogin()" class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Back to Login</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="successModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-5 shadow-lg text-center relative">
            <button onclick="redirectToLogin()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
                &times; <!-- X button -->
            </button>
            <h3 class="text-lg font-semibold mb-4">Success!</h3>
            <p id="modalMessage" class="text-gray-700"></p>
            <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" onclick="document.getElementById('successModal').classList.add('hidden')">Close</button>
        </div>
    </div>
</body>
</html>
