<?php

// Function to handle user login
function loginUser($db, $username, $password)
{
    // Prepare the SQL statement
    $stmt = $db->prepare("SELECT id, username,status, name, surename, password,email,expiration FROM users WHERE status = 1 AND email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if ($password == $user['password']) {
            // Set session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['fullname'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['surename'] = $user['surename'];
            $_SESSION['status'] = $user['status'];

            // Return success
            return true;
        } else {
            // Incorrect password
            return "Invalid password.";
        }
    } else {
        // User not found or inactive
        return "User not found or inactive.";
    }
}

function logoutUser()
{
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // Redirect to the login page or home page
    header("Location: login.php");
    exit();
}