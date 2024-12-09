<?php
session_start();
include 'db.php';

// Periksa apakah pengguna sudah login dan memiliki peran creator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'creator') {
    echo "<script>
            alert('Hanya creator yang dapat menambah laundry!');
            window.location.href = 'index.php';
          </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $price = trim($_POST['price']); // Tetap varchar
    $photo = $_FILES['photo']['name'];

    // Validasi input
    if (empty($name) || empty($address) || empty($price) || empty($photo)) {
        $error = "Semua field wajib diisi!";
    } elseif (!is_numeric($price) && !preg_match('/^[a-zA-Z0-9 ]+$/', $price)) {
        $error = "Harga hanya boleh berupa angka atau teks yang valid!";
    } else {
        // Proses upload foto
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        // Validasi format file
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = mime_content_type($_FILES['photo']['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $error = "Hanya file JPEG, JPG, atau PNG yang diperbolehkan!";
        } elseif (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            // Masukkan data ke dalam database
            $stmt = $conn->prepare("INSERT INTO laundry (name, address, price, photo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $address, $price, $photo);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Laundry berhasil ditambahkan!');
                        window.location.href = 'laundry_list.php';
                      </script>";
                exit();
            } else {
                $error = "Terjadi kesalahan saat menyimpan ke database: " . $stmt->error;
            }
        } else {
            $error = "Gagal mengupload foto!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Laundry</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
/* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
}

/* Header */
header {
    background-color: #4CAF50;
    color: white;
    padding: 1rem;
    text-align: center;
    font-size: 1.5rem;
}

/* Kontainer utama */
.container {
    max-width: 700px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

/* Judul halaman */
h1 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #4CAF50;
    font-size: 2rem;
}

/* Formulir */
form {
    display: flex;
    flex-direction: column;
}

form label {
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #333;
}

form input[type="text"],
form input[type="file"] {
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    width: 100%;
}

form input[type="file"] {
    padding: 0.4rem;
}

form button {
    padding: 0.8rem 1.5rem;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    text-align: center;
}

form button:hover {
    background-color: #45a049;
}

/* Pesan error */
.error {
    color: red;
    background-color: #ffecec;
    padding: 1rem;
    margin-bottom: 1.5rem;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
    text-align: center;
}

/* Tombol kembali */
.kembali {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 1rem;
    text-align: center;
}

.kembali:hover {
    background-color: #45a049;
}

/* Footer */
footer {
    text-align: center;
    padding: 1rem;
    background: #333;
    color: white;
    margin-top: 2rem;
    border-radius: 5px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Laundry</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Laundry:</label>
            <input type="text" name="name" required>
            <br>
            <label>Alamat:</label>
            <input type="text" name="address" required>
            <br>
            <label>Harga:</label>
            <input type="text" name="price" required>
            <br>
            <label>Foto:</label>
            <input type="file" name="photo" accept="image/jpeg, image/png, image/jpg" required>
            <br>
            <button type="submit">Tambah Laundry</button>
        </form>
        <a href="laundry_list.php" class="kembali">kembali</a>
    </div>
</body>
</html>
