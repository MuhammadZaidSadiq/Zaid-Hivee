<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all books from database
$sql = "SELECT books.*, users.username, users.email FROM books 
        JOIN users ON books.user_id = users.id 
        ORDER BY books.created_at DESC";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Hive - Home</title>
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
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mybooks.php">My Books</a>
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
        <h1 class="page-title">Available Books</h1>
        <p class="page-subtitle">Browse and exchange books with fellow students</p>

        <div class="books-grid">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($book = $result->fetch_assoc()) {
                    ?>
                    <div class="book-card">
                        <div class="book-image">
                            <img src="uploads/<?php echo htmlspecialchars($book['book_image']); ?>" 
                                 alt="<?php echo htmlspecialchars($book['book_title']); ?>">
                        </div>
                        <div class="book-details">
                            <h5 class="book-title"><?php echo htmlspecialchars($book['book_title']); ?></h5>
                            <p class="book-author">by <?php echo htmlspecialchars($book['author']); ?></p>
                            <div class="book-info">
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($book['book_condition']); ?></span>
                                <span class="badge bg-info text-dark"><?php echo htmlspecialchars($book['pages']); ?> pages</span>
                            </div>
                            <p class="book-owner">Listed by: <strong><?php echo htmlspecialchars($book['username']); ?></strong></p>
                            <p class="book-contact">
                                <i class="fas fa-envelope"></i> 
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($book['email']); ?>&su=<?php echo urlencode('Book Exchange Request - ' . $book['book_title']); ?>&body=<?php echo urlencode('Hi ' . $book['username'] . ',

I am interested in exchanging the book "' . $book['book_title'] . '" that you listed on Book Hive.

Please let me know if it is still available.

Thank you!'); ?>" target="_blank">
                                    <?php echo htmlspecialchars($book['email']); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="alert alert-info w-100">No books available yet. Be the first to list a book!</div>';
            }
            ?>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>