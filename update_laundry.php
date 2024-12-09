<?php
session_start();
include 'db.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah pengguna adalah creator
if ($_SESSION['role'] !== 'creator') {
    echo "<script>
            alert('Hanya creator yang dapat mengedit laundry!');
            window.location.href = 'index.php';
          </script>";
    exit();
}

// Lanjutkan dengan proses edit jika creator
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data laundry berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM laundry WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $laundry = $result->fetch_assoc();
    } else {
        echo "<script>
                alert('Laundry tidak ditemukan!');
                window.location.href = 'laundry_list.php';
              </script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $price = $_POST['price'];

    // Perbarui data laundry di database
    $stmt = $conn->prepare("UPDATE laundry SET name = ?, address = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $name, $address, $price, $id);
    $stmt->execute();

    echo "<script>
            alert('Laundry berhasil diperbarui!');
            window.location.href = 'laundry_list.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laundry</title>
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
.home-button {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 1rem;
    text-align: center;
}

.home-button:hover {
    background-color: #45a049;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Laundry</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $laundry['id']; ?>">
            <label>Nama Laundry:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($laundry['name']); ?>" required>
            <br>
            <label>Alamat:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($laundry['address']); ?>" required>
            <br>
            <label>Harga Laundry:</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($laundry['price']); ?>" required pattern="\d*" >
            <br>
            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="index.php" class="home-button">Kembali</a>
    </div>
</body>
</html>
