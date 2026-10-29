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
    echo "<script>
            alert('Book not found or you do not have permission to edit this book.');
            window.location.href = 'mybooks.php';
          </script>";
    exit();
}

$book = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Hive - Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="logo.png" alt="Book Hive Logo" class="logo-img">
                Book Hive
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="mybooks.php">My Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listbook.php">List a Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="form-box mx-auto" style="max-width: 700px;">
            <h1 class="form-heading">Edit Book</h1>
            <p class="form-subtext">Update your book information</p>

            <div class="row mb-4">
                <div class="col-md-4 text-center">
                    <img src="uploads/<?php echo htmlspecialchars($book['book_image']); ?>" 
                         alt="Current Book Image" 
                         class="img-fluid rounded"
                         style="max-height: 200px;">
                    <p class="text-muted mt-2">Current Image</p>
                </div>
                <div class="col-md-8">
                    <form name="editBookForm" action="editbookprocess.php" method="POST" enctype="multipart/form-data" onsubmit="return validateBookForm()">
                        <input type="hidden" name="bookId" value="<?php echo $book['id']; ?>">
                        <input type="hidden" name="oldImage" value="<?php echo $book['book_image']; ?>">

                        <div class="mb-3">
                            <label for="bookTitle" class="form-label">Book Title</label>
                            <input type="text" class="form-control" id="bookTitle" name="bookTitle" 
                                   value="<?php echo htmlspecialchars($book['book_title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" name="author" 
                                   value="<?php echo htmlspecialchars($book['author']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="pages" class="form-label">Number of Pages</label>
                            <input type="number" class="form-control" id="pages" name="pages" 
                                   value="<?php echo htmlspecialchars($book['pages']); ?>" required min="2">
                            <small class="form-text text-muted">Must be more than 1 page</small>
                        </div>

                        <div class="mb-3">
                            <label for="condition" class="form-label">Book Condition</label>
                            <select class="form-select" id="condition" name="condition" required>
                                <option value="">Select condition</option>
                                <option value="Like New" <?php echo ($book['book_condition'] == 'Like New') ? 'selected' : ''; ?>>Like New</option>
                                <option value="Good" <?php echo ($book['book_condition'] == 'Good') ? 'selected' : ''; ?>>Good</option>
                                <option value="Fair" <?php echo ($book['book_condition'] == 'Fair') ? 'selected' : ''; ?>>Fair</option>
                                <option value="Poor" <?php echo ($book['book_condition'] == 'Poor') ? 'selected' : ''; ?>>Poor</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bookImage" class="form-label">Change Book Cover Image (Optional)</label>
                            <input type="file" class="form-control" id="bookImage" name="bookImage" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep current image</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" name="submit">Update Book</button>
                            <a href="mybooks.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="validation.js"></script>
</body>
</html>