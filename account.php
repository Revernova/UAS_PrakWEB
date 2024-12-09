<?php
session_start();
include 'db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna berdasarkan user_id
$stmt = $conn->prepare("SELECT name, email, phone, location, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses form update akun
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];

    $profile_picture = $user['profile_picture']; // Default to current picture

    // Jika ada file yang diupload
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi file gambar
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if ($check !== false && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file;
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "File is not a valid image.";
        }
    }

    // Update data pengguna
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, location = ?, profile_picture = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $location, $profile_picture, $_SESSION['user_id']);
    $stmt->execute();

    // Refresh data pengguna
    header("Location: account.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Akun Saya</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
    background-image: url('asset/laundry.jpg'); /* Path ke gambar background */
    background-size: cover; /* Gambar memenuhi seluruh area */
    background-repeat: no-repeat; /* Mencegah pengulangan */
    background-attachment: fixed; /* Background tetap saat di-scroll */
    background-position: center; /* Gambar diposisikan di tengah */
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    }

    header {
        position: fixed;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 1000; 
        }

    header nav ul {
        list-style: none;
        display: flex;
    }

    header nav ul li {
        margin-left: 0px;
        font-size: 18px;
    }

    header nav ul li a {
        text-decoration: none;
        color: white;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    header nav ul li a:hover {
        color: #ddd;
    }

    .container {
        max-width: 600px;
        margin: 100px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
    }

    .container img {
        display: block;
        margin: 0 auto 20px;
        max-width: 150px;
        border-radius: 50%;
        border: 4px solid #4CAF50;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .container h1 {
        text-align: center;
        font-size: 1.8rem;
        color: #4CAF50;
        margin-bottom: 20px;
    }

    p {
        margin-bottom: 15px;
        font-size: 18;
        color: #555;
    }

    p strong {
        color: #333;

    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus {
        border-color: #4CAF50;
        outline: none;
    }

    .form-group button {
        display: inline-block;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .form-group button:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    .button-container {
        text-align: center;
        margin-top: 20px;
    }

    .button-container a {
        text-decoration: none;
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button-container a:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }
    

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="asset/Kazuki_Laundry.png" alt="Logo Laundry">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="account.php">Akun Saya</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
         </nav>
    </header>

    <div class="container">
        <h1>Akun Saya</h1>

        <?php if (!isset($_GET['edit'])): ?>
            <!-- Tampilkan informasi akun -->
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Foto Profil">
            <?php else: ?>
                <img src="default-profile.png" alt="Default Profil">
            <?php endif; ?>

            <p><strong>Nama:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>No Telp:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($user['location']); ?></p>

            <div class="button-container">
                <a href="account.php?edit=true" class="form-group button">Update Informasi</a>
            </div>
        <?php else: ?>
            <!-- Form update akun -->
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">No Telp</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user['location']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Foto Profil</label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                </div>
                <div class="form-group">
                    <button type="submit" name="update_account">Simpan Perubahan</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
<footer>
    <p>&copy; 2024 Laundry Service</p>
</footer>
</html>