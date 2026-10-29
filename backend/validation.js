// Book Listing Form Validation
function validateBookForm() {
    // Get form values
    const bookTitle = document.getElementById('bookTitle').value.trim();
    const author = document.getElementById('author').value.trim();
    const pages = document.getElementById('pages').value;
    const condition = document.getElementById('condition').value;
    const bookImageInput = document.getElementById('bookImage');
    const bookImage = bookImageInput ? bookImageInput.files[0] : null;

    // Validate book title
    if (bookTitle === '') {
        alert('Please enter the book title.');
        document.getElementById('bookTitle').focus();
        return false;
    }

    if (bookTitle.length < 2) {
        alert('Book title must be at least 2 characters long.');
        document.getElementById('bookTitle').focus();
        return false;
    }

    if (bookTitle.length > 200) {
        alert('Book title cannot exceed 200 characters.');
        document.getElementById('bookTitle').focus();
        return false;
    }

    // Validate author
    if (author === '') {
        alert('Please enter the author name.');
        document.getElementById('author').focus();
        return false;
    }

    if (author.length < 2) {
        alert('Author name must be at least 2 characters long.');
        document.getElementById('author').focus();
        return false;
    }

    if (author.length > 100) {
        alert('Author name cannot exceed 100 characters.');
        document.getElementById('author').focus();
        return false;
    }

    // Check if author contains only letters and spaces
    const authorPattern = /^[a-zA-Z\s.'-]+$/;
    if (!authorPattern.test(author)) {
        alert('Author name can only contain letters, spaces, dots, hyphens and apostrophes.');
        document.getElementById('author').focus();
        return false;
    }

    // Validate pages - must be more than 1
    if (pages === '' || pages <= 1) {
        alert('Number of pages must be more than 1.');
        document.getElementById('pages').focus();
        return false;
    }

    if (pages > 10000) {
        alert('Number of pages seems too high. Please enter a valid number (max 10000).');
        document.getElementById('pages').focus();
        return false;
    }

    // Validate condition
    if (condition === '') {
        alert('Please select the book condition.');
        document.getElementById('condition').focus();
        return false;
    }

    // Validate image only if it's required (on add page, not edit page)
    if (bookImageInput && bookImageInput.hasAttribute('required')) {
        if (!bookImage) {
            alert('Please select a book cover image.');
            bookImageInput.focus();
            return false;
        }
    }

    // If image is selected, validate it
    if (bookImage) {
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(bookImage.type)) {
            alert('Please upload a valid image file (JPG, PNG, or GIF).');
            bookImageInput.focus();
            return false;
        }

        // Check file size (5MB limit)
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (bookImage.size > maxSize) {
            alert('Image file is too large. Maximum size is 5MB.');
            bookImageInput.focus();
            return false;
        }
    }

    // All validations passed
    return true;
}

// Signup Form Validation
function validateSignupForm() {
    // Get form values
    const username = document.getElementById('user').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('pass').value;
    const confirmPassword = document.getElementById('cpass').value;

    // Validate username
    if (username === '') {
        alert('Please enter a username.');
        document.getElementById('user').focus();
        return false;
    }

    if (username.length < 3) {
        alert('Username must be at least 3 characters long.');
        document.getElementById('user').focus();
        return false;
    }

    if (username.length > 50) {
        alert('Username cannot exceed 50 characters.');
        document.getElementById('user').focus();
        return false;
    }

    // Username should contain only letters, numbers, and underscores
    const usernamePattern = /^[a-zA-Z0-9_]+$/;
    if (!usernamePattern.test(username)) {
        alert('Username can only contain letters, numbers, and underscores.');
        document.getElementById('user').focus();
        return false;
    }

    // Validate email
    if (email === '') {
        alert('Please enter your email address.');
        document.getElementById('email').focus();
        return false;
    }

    // Email must contain @
    if (!email.includes('@')) {
        alert('Please enter a valid email address containing "@".');
        document.getElementById('email').focus();
        return false;
    }

    // More comprehensive email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address (e.g., user@example.com).');
        document.getElementById('email').focus();
        return false;
    }

    // Validate password - must be 8 characters with at least one digit
    if (password === '') {
        alert('Please enter a password.');
        document.getElementById('pass').focus();
        return false;
    }

    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        document.getElementById('pass').focus();
        return false;
    }

    // Check if password contains at least one digit
    const hasDigit = /\d/.test(password);
    if (!hasDigit) {
        alert('Password must contain at least one digit (0-9).');
        document.getElementById('pass').focus();
        return false;
    }

    // Validate confirm password
    if (confirmPassword === '') {
        alert('Please confirm your password.');
        document.getElementById('cpass').focus();
        return false;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match. Please try again.');
        document.getElementById('cpass').focus();
        return false;
    }

    // All validations passed
    return true;
}

// Login Form Validation
function validateLoginForm() {
    // Get form values
    const username = document.getElementById('user').value.trim();
    const password = document.getElementById('pass').value;

    // Validate username
    if (username === '') {
        alert('Please enter your username.');
        document.getElementById('user').focus();
        return false;
    }

    // Validate password
    if (password === '') {
        alert('Please enter your password.');
        document.getElementById('pass').focus();
        return false;
    }

    // All validations passed
    return true;
}

// Contact Form Validation
function validateContactForm() {
    // Get form values
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const subject = document.getElementById('subject').value.trim();
    const message = document.getElementById('message').value.trim();

    // Validate name
    if (name === '') {
        alert('Please enter your name.');
        document.getElementById('name').focus();
        return false;
    }

    if (name.length < 2) {
        alert('Name must be at least 2 characters long.');
        document.getElementById('name').focus();
        return false;
    }

    // Validate email
    if (email === '') {
        alert('Please enter your email address.');
        document.getElementById('email').focus();
        return false;
    }

    if (!email.includes('@')) {
        alert('Please enter a valid email address containing "@".');
        document.getElementById('email').focus();
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        document.getElementById('email').focus();
        return false;
    }

    // Validate subject
    if (subject === '') {
        alert('Please enter a subject.');
        document.getElementById('subject').focus();
        return false;
    }

    if (subject.length < 3) {
        alert('Subject must be at least 3 characters long.');
        document.getElementById('subject').focus();
        return false;
    }

    // Validate message
    if (message === '') {
        alert('Please enter your message.');
        document.getElementById('message').focus();
        return false;
    }

    if (message.length < 10) {
        alert('Message must be at least 10 characters long.');
        document.getElementById('message').focus();
        return false;
    }

    // All validations passed
    return true;
}

// Add real-time validation feedback when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Pages input validation - ensure minimum is 2
    const pagesInput = document.getElementById('pages');
    if (pagesInput) {
        pagesInput.setAttribute('min', '2');
        pagesInput.addEventListener('input', function() {
            if (this.value < 2) {
                this.value = 2;
            }
            if (this.value > 10000) {
                this.value = 10000;
            }
        });
    }

    // Password strength indicator for signup
    const passwordInput = document.getElementById('pass');
    if (passwordInput && window.location.href.includes('signup')) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const hasDigit = /\d/.test(password);
            const isLongEnough = password.length >= 8;
            
            // You can add visual feedback here if needed
            if (password.length > 0) {
                if (!isLongEnough) {
                    this.style.borderColor = 'red';
                } else if (!hasDigit) {
                    this.style.borderColor = 'orange';
                } else {
                    this.style.borderColor = 'green';
                }
            } else {
                this.style.borderColor = '';
            }
        });
    }

    // Email validation on input
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            const email = this.value;
            if (email.length > 0) {
                if (!email.includes('@')) {
                    this.style.borderColor = 'red';
                } else {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (emailPattern.test(email)) {
                        this.style.borderColor = 'green';
                    } else {
                        this.style.borderColor = 'orange';
                    }
                }
            } else {
                this.style.borderColor = '';
            }
        });
    }

    // Image preview functionality
    const imageInput = document.getElementById('bookImage');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, or GIF).');
                    this.value = '';
                    return;
                }
                
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Image file is too large. Maximum size is 5MB.');
                    this.value = '';
                    return;
                }
            }
        });
    }
});