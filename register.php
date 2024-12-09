<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, location, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $location, $password, $role);
        $stmt->execute();

        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['role'] = $role;
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* Reset default margin and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f0f0;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Container Form */
.container {
    width: 100%;
    max-width: 400px;
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

/* Title */
h1 {
    text-align: center;
    font-size: 24px;
    color: #4CAF50;
    margin-bottom: 20px;
}

/* Form Input */
input[type="text"],
input[type="password"],
input[type="email"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    font-size: 16px;
    color: #333;
}

/* Input Focus Effect */
input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus {
    border-color: #4CAF50;
    outline: none;
    background-color: #e8f5e9;
}

/* Submit Button */
button {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

/* Link to Switch Forms (Login / Register) */
a {
    color: #4CAF50;
    text-decoration: none;
    text-align: center;
    display: block;
    margin-top: 10px;
}

a:hover {
    text-decoration: underline;
}

/* Form Group (Login or Register) */
.form-group {
    margin-bottom: 15px;
}

/* Footer */
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
    padding: 10px;
    background-color: #333;
    color: white;
}

/* Responsive Design for Smaller Devices */
@media (max-width: 600px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    h1 {
        font-size: 20px;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>Nama:</label>
            <input type="text" name="name" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>No Telp:</label>
            <input type="text" name="phone" required>
            <label>Lokasi:</label>
            <input type="text" name="location" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <label>Peran:</label>
            <select name="role" required>
                <option value="customer">Customer</option>
                <option value="creator">Creator</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>
