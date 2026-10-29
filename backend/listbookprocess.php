<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $userId = $_SESSION['user_id'];
    $bookTitle = trim($_POST['bookTitle']);
    $author = trim($_POST['author']);
    $pages = intval($_POST['pages']);
    $condition = trim($_POST['condition']);

    // Handle file upload
    $targetDir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["bookImage"]["name"], PATHINFO_EXTENSION));
    $newFileName = uniqid() . '.' . $imageFileType;
    $targetFile = $targetDir . $newFileName;

    // Check if image file is actual image
    $check = getimagesize($_FILES["bookImage"]["tmp_name"]);
    if ($check === false) {
        echo "<script>
                alert('File is not an image.');
                window.location.href = 'listbook.php';
              </script>";
        exit();
    }

    // Check file size (limit to 5MB)
    if ($_FILES["bookImage"]["size"] > 5000000) {
        echo "<script>
                alert('Sorry, your file is too large. Maximum size is 5MB.');
                window.location.href = 'listbook.php';
              </script>";
        exit();
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>
                alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                window.location.href = 'listbook.php';
              </script>";
        exit();
    }

    // Upload file
    if (move_uploaded_file($_FILES["bookImage"]["tmp_name"], $targetFile)) {
        // Insert book into database
        $stmt = $conn->prepare("INSERT INTO books (user_id, book_title, author, pages, book_condition, book_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $userId, $bookTitle, $author, $pages, $condition, $newFileName);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Book listed successfully!');
                    window.location.href = 'home.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error listing book. Please try again.');
                    window.location.href = 'listbook.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Sorry, there was an error uploading your file.');
                window.location.href = 'listbook.php';
              </script>";
    }
}
?>