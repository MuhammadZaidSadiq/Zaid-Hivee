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
    $bookId = intval($_POST['bookId']);
    $bookTitle = trim($_POST['bookTitle']);
    $author = trim($_POST['author']);
    $pages = intval($_POST['pages']);
    $condition = trim($_POST['condition']);
    $oldImage = $_POST['oldImage'];

    // Verify ownership
    $checkOwner = $conn->prepare("SELECT id FROM books WHERE id = ? AND user_id = ?");
    $checkOwner->bind_param("ii", $bookId, $userId);
    $checkOwner->execute();
    $ownerResult = $checkOwner->get_result();

    if ($ownerResult->num_rows === 0) {
        echo "<script>
                alert('You do not have permission to edit this book.');
                window.location.href = 'mybooks.php';
              </script>";
        exit();
    }

    // Check if new image is uploaded
    if (!empty($_FILES["bookImage"]["name"])) {
        // New image uploaded - process it
        $targetDir = "uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["bookImage"]["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $newFileName;

        // Validate image
        $check = getimagesize($_FILES["bookImage"]["tmp_name"]);
        if ($check === false) {
            echo "<script>
                    alert('File is not an image.');
                    window.location.href = 'editbook.php?id=$bookId';
                  </script>";
            exit();
        }

        // Check file size (limit to 5MB)
        if ($_FILES["bookImage"]["size"] > 5000000) {
            echo "<script>
                    alert('Sorry, your file is too large. Maximum size is 5MB.');
                    window.location.href = 'editbook.php?id=$bookId';
                  </script>";
            exit();
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>
                    alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                    window.location.href = 'editbook.php?id=$bookId';
                  </script>";
            exit();
        }

        // Upload new file
        if (move_uploaded_file($_FILES["bookImage"]["tmp_name"], $targetFile)) {
            // Delete old image
            if (file_exists($targetDir . $oldImage)) {
                unlink($targetDir . $oldImage);
            }
            $imageName = $newFileName;
        } else {
            echo "<script>
                    alert('Sorry, there was an error uploading your file.');
                    window.location.href = 'editbook.php?id=$bookId';
                  </script>";
            exit();
        }
    } else {
        // No new image - keep old image
        $imageName = $oldImage;
    }

    // Update book in database
    $stmt = $conn->prepare("UPDATE books SET book_title = ?, author = ?, pages = ?, book_condition = ?, book_image = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssissii", $bookTitle, $author, $pages, $condition, $imageName, $bookId, $userId);

    if ($stmt->execute()) {
        echo "<script>
                alert('Book updated successfully!');
                window.location.href = 'mybooks.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating book. Please try again.');
                window.location.href = 'editbook.php?id=$bookId';
              </script>";
    }
}
?>