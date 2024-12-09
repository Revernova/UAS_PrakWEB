<?php
session_start();
include 'db.php';

// Periksa apakah pengguna sudah login dan memiliki peran creator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'creator') {
    echo "<script>
            alert('Hanya creator yang dapat menghapus laundry!');
            window.location.href = 'index.php';
          </script>";
    exit();
}

// Ambil ID dari POST
$id = $_POST['id'] ?? null;

// Periksa apakah ID valid
if ($id === null || !is_numeric($id)) {
    echo "<script>
            alert('ID laundry tidak diberikan atau tidak valid!');
            window.location.href = 'laundry_list.php';
          </script>";
    exit();
}

// Query untuk mendapatkan data laundry (termasuk foto)
$stmt = $conn->prepare("SELECT photo FROM laundry WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $laundry = $result->fetch_assoc();
    $photo = "uploads/" . $laundry['photo'];

    // Hapus foto dari direktori jika ada
    if (file_exists($photo)) {
        unlink($photo);
    }

    // Hapus data laundry dari database
    $stmt = $conn->prepare("DELETE FROM laundry WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "<script>
            alert('Laundry berhasil dihapus!');
            window.location.href = 'laundry_list.php';
          </script>";
    exit();
} else {
    echo "<script>
            alert('Laundry tidak ditemukan!');
            window.location.href = 'laundry_list.php';
          </script>";
    exit();
}
?>
