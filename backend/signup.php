<?php 
    include("connection.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Hive - Sign Up</title>
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
            <h1 class="form-heading">Sign Up</h1>
            <p class="form-subtext">Join Book Hive to exchange books!</p>
            
            <form name="signupForm" action="signupprocess.php" method="POST" onsubmit="return validateSignupForm()">
                <div class="mb-3">
                    <input type="text" class="form-control" id="user" name="user" placeholder="Enter Username" required>
                    <small class="form-text text-muted">3-50 characters, letters, numbers, and underscores only</small>
                </div>
                
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                    <small class="form-text text-muted">Must contain @ symbol</small>
                </div>
                
                <div class="mb-3">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Create Password" required>
                    <small class="form-text text-muted">Minimum 8 characters with at least one digit</small>
                </div>
                
                <div class="mb-3">
                    <input type="password" class="form-control" id="cpass" name="cpass" placeholder="Confirm Password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100" name="submit">Sign Up</button>
            </form>
            
            <p class="form-footer">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="validation.js"></script>
</body>
</html>