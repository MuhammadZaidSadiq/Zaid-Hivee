<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get book ID from URL
if (!isset($_GET['id'])) {
    header("Location: mybooks.php");
    exit();
}

$bookId = intval($_GET['id']);
$userId = $_SESSION['user_id'];

// Fetch book details - verify ownership
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $bookId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = 'Book not found or you do not have permission to delete this book.';
    header("Location: mybooks.php");
    exit();
}

$book = $result->fetch_assoc();

// Delete the book image from uploads folder
$imagePath = "uploads/" . $book['book_image'];
if (file_exists($imagePath)) {
    unlink($imagePath);
}

// Delete the book from database
$deleteStmt = $conn->prepare("DELETE FROM books WHERE id = ? AND user_id = ?");
$deleteStmt->bind_param("ii", $bookId, $userId);

if ($deleteStmt->execute()) {
    $_SESSION['success_message'] = 'Book deleted successfully!';
    header("Location: mybooks.php");
    exit();
} else {
    $_SESSION['error_message'] = 'Error deleting book. Please try again.';
    header("Location: mybooks.php");
    exit();
}
?>