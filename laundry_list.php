﻿<?php
session_start();
include 'db.php'; // Koneksi database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laundry</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>   
         /* Animasi Bagian */
        .about,
        .intro,
        .advantages,
        .view-laundry {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeIn 2s ease-out forwards;
        }

        .about {
            animation-delay: 0.3s;
        }

        .intro {
            animation-delay: 0.6s;
        }

        .advantages {
            animation-delay: 0.9s;
        }

        .view-laundry {
            animation-delay: 1.2s;
        }

        /* Efek FadeIn */
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
        
        /* Tombol Animasi */
        .btn:hover {
        transform: scale(1.1);
        }

        /* Keunggulan Laundry Efek Slide */
        .advantages ul li {
            opacity: 0;
            animation: slideInLeft 1s ease-out forwards;
            animation-delay: calc(var(--delay, 1) * 0.2s);
        }

        header {
        position: fixed;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 1000; /* Pastikan header tetap di atas */
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

        .container {
            max-width: 1200px;
            margin: 100px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .add-button {
            font-size: 16px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-button:hover {
            background-color: #45a049;
        }

        .laundry-item {
            display: flex;
            align-items: center;
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .laundry-item img {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            margin-right: 20px;
            object-fit: cover;
        }

        .laundry-item .details {
            flex: 1;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px; /* Membesarkan ukuran huruf tombol */
            transition: text-decoration 0.3s ease;
        }

        .laundry-item h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 5px;
        }

        .laundry-item p {
            font-size: 19px;
            color: #777;
        }

        .menu-button {
            font-size: 24px;
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #4CAF50;
        }

        .menu-button:hover {
            color: #45a049;
        }

        .menu-dropdown {
            display: none;
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 10px;
            z-index: 10;
        }

        .menu-dropdown button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            margin-bottom: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .menu-dropdown button:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            margin-top: 30px;
            border-radius: 5px;
        }
        
        /* Efek FadeIn */
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
        <!-- Logo di sebelah kiri -->
        <div class="logo">
            <img src="asset/Kazuki_Laundry.png" alt="Logo Laundry">
        </div>
        <!-- Menu navigasi di sebelah kanan -->
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="account.php">Akun Saya</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="list-header">
            <h1>List Laundry</h1>
            <button onclick="location.href='add_laundry.php'" class="add-button">+ Tambah Laundry</button>
        </div>

        <!-- Daftar Laundry -->
        <div class="laundry-list">
            <?php
            $result = $conn->query("SELECT * FROM laundry"); // Ambil data dari tabel laundry
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                echo "
                <div class='laundry-item'>
                    <img src='uploads/{$row['photo']}' alt='Foto Laundry'>
                    <div class='details'>
                        <h2>{$row['name']}</h2>
                        <p><strong>Alamat:</strong> {$row['address']}</p>
                        <p><strong>Harga:</strong> {$row['price']}/kg</p>
                    </div>
                    <button class='menu-button' onclick='toggleMenu(\"menu-$id\")'>⋮</button>
                    <div id='menu-$id' class='menu-dropdown'>
                        <form action='update_laundry.php' method='GET'>
                            <input type='hidden' name='id' value='$id'>
                            <button type='submit'>Edit</button>
                        </form>
                        <form action='delete_laundry.php' method='POST' onsubmit='return confirm(\"Yakin ingin menghapus?\")'>
                            <input type='hidden' name='id' value='$id'>
                            <button type='submit'>Hapus</button>
                        </form>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Laundry Service</p>
    </footer>

    <script>
        // Toggle dropdown menu
        function toggleMenu(menuId) {
            // Tutup semua dropdown lainnya
            document.querySelectorAll('.menu-dropdown').forEach(menu => {
                if (menu.id !== menuId) {
                    menu.style.display = 'none';
                }
            });

            // Tampilkan atau sembunyikan menu yang dipilih
            const menu = document.getElementById(menuId);
            if (menu) {
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            }
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function (event) {
            const isMenuButton = event.target.classList.contains('menu-button');
            if (!isMenuButton) {
                document.querySelectorAll('.menu-dropdown').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>