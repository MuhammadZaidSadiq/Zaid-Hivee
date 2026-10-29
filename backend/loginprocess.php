<?php
session_start();
include("connection.php");

if (isset($_POST['login'])) {
    $username = trim($_POST['user']);
    $password = trim($_POST['pass']);

    // Use prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the hashed password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            
            header("Location: home.php");
            exit();
        } else {
            echo "<script>
                    alert('Invalid Password');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not found');
                window.location.href = 'login.php';
              </script>";
    }
}
?>