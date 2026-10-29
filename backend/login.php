<?php 
    include("connection.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Hive - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="logo.png" alt="Book Hive Logo" class="logo-img">
                Book Hive
            </a>
        </div>
    </nav>

    <div class="form-container">
        <div class="form-box">
            <h1 class="form-heading">Login</h1>
            <p class="form-subtext">Welcome back to Book Hive!</p>
            
            <form name="loginForm" action="loginprocess.php" method="POST" onsubmit="return validateLoginForm()">
                <div class="mb-3">
                    <input type="text" class="form-control" id="user" name="user" placeholder="Enter Username" required>
                </div>
                
                <div class="mb-3">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter Password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
            </form>
            
            <p class="form-footer">Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="validation.js"></script>
</body>
</html>