<?php
session_start();
include 'php/db_connect.php';

$message = ''; // Initialize an empty message
$role = isset($_GET['role']) ? $_GET['role'] : 'employer'; // Default role is 'employer'

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from the form, using mysqli_real_escape_string for security
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : 'employer'; // Set role from POST, default to 'employer'

    // Check if username and password are provided
    if (!empty($username) && !empty($password)) {
        // Query to check if the username exists for the specific role
        $query = "SELECT * FROM users WHERE username='$username' AND role='$role'";
        $result = mysqli_query($conn, $query); // Execute the query

        if (!$result) {
            // Log error if query fails
            error_log("Query failed: " . mysqli_error($conn)); 
            $message = "Database query error.";
        } else {
            // Fetch the result
            $user = mysqli_fetch_assoc($result);

            if (!$user) {
                // If no user found, display this message
                $message = "Username not found.";
            } elseif (password_verify($password, $user['password'])) {
                // If user found and password matches, log in the user
                $_SESSION['user'] = $username;
                $_SESSION['role'] = $role;
                if ($role === 'employer') {
                    $_SESSION['employer_id'] = $user['id'];
                }
                header('Location: employer_dashboard.php'); // Redirect to employer dashboard
                exit();
            } else {
                // If the password is incorrect, display this message
                $message = "Invalid credentials.";
            }
        }
    } else {
        // If either username or password is empty
        $message = "Please fill in both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <section class="bg-gray-50 dark:bg-gray-900 py-16">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto" src="./assets/images/tvac-logo-1.png" alt="The Virtual Aid Co. Logo" style="height: 170px; width: auto;">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <!-- Form for login -->
                <form class="space-y-6" method="POST">
                    <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>" />

                    <!-- Display error message if it exists -->
                    <?php if (!empty($message)): ?>
                        <div class="text-red-500 text-sm">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Enter your username" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="••••••••" />
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                    Not a member?
                    <a href="create_user.php?role=<?php echo htmlspecialchars($role); ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Register Now!</a>
                </p>
            </div>
        </div>
    </section>
</body>
</html>
