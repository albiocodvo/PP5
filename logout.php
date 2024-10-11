<?php
session_start();
session_destroy(); // Destroy all session data
header('Location: landing_page.php'); // Redirect to the landing page or login page
exit();
?>
