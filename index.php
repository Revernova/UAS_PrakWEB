<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Laundry Service</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>

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

    h1, h2 {
    margin-bottom: 1rem;
    color: #4CAF50;
    }

    footer {
    text-align: center;
    padding: 1rem;
    background: #333;
    color: white;
    width: 100%;
    }

    .container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: center;
    }
    
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

    /* Keunggulan Laundry Efek Slide */
    .advantages ul li {
        opacity: 0;
        animation: slideInLeft 1s ease-out forwards;
        animation-delay: calc(var(--delay, 1) * 0.2s);
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Tombol Animasi */
    .btn:hover {
        transform: scale(1.1);
    }

    li {
      font-size: 18px; /* Ukuran dalam piksel */
      text-align: left;
    }

    h1 {
        font-size: 36px;
    }

    p {
      font-size: 18px; /* Ukuran dalam piksel */
      text-align: center;
    }
    </style>
</head>
<body>
    <!-- Header -->
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

    <!-- Konten utama -->
    <div class="container">
        <!-- Welcome Section -->
        <section class="welcome">
            <h1>Selamat datang di layanan GoLaundry kami</h1>
        </section>

        <!-- About Us Section -->
        <section class="about">
            <h2>About Us</h2>
            <p>Selamat datang di GoLaundry, platform terlengkap untuk menemukan layanan laundry terbaik di sekitar Anda! Kami hadir untuk mempermudah hidup Anda dengan menghadirkan daftar laundry terpercaya, lengkap dengan informasi layanan, harga, dan ulasan pelanggan.
                Misi kami adalah menghubungkan Anda dengan penyedia laundry yang cepat, berkualitas, dan terjangkau. Temukan berbagai jenis layanan mulai dari cuci kiloan, dry cleaning, hingga penanganan pakaian khusus hanya dalam satu platform.
                Bersama GoLaundry, kebutuhan laundry Anda menjadi lebih mudah dan efisien!</p>
        </section>

        <!-- Pengenalan Laundry -->
        <section class="intro">
            <h2>Pengenalan Laundry</h2>
            <p>Selamat datang di GoLaundry, platform terpercaya untuk menemukan layanan laundry terbaik di sekitar Anda! Kami menghadirkan daftar laundry yang lengkap dengan informasi lokasi, layanan, dan harga, sehingga Anda dapat memilih yang paling sesuai dengan kebutuhan Anda.
                Apa yang kami tawarkan:
                Daftar Laundry Terlengkap: Temukan berbagai layanan laundry di lokasi terdekat Anda.
                Informasi Lokasi: Dilengkapi dengan peta dan alamat yang memudahkan Anda menuju tempat laundry pilihan.
                Harga Transparan: Bandingkan harga untuk mendapatkan layanan terbaik dengan anggaran yang sesuai.
                Ulasan Pengguna: Baca pengalaman pelanggan lain sebelum Anda memutuskan.
                Dengan GoLaundry, kebutuhan laundry Anda menjadi lebih mudah, cepat, dan efisien. Hemat waktu Anda dan temukan laundry favorit Anda hanya dengan beberapa klik!</p>
        </section>

        <!-- Keunggulan Laundry -->
        <section class="advantages">
            <h2>Keunggulan Kami</h2>
                <li><strong>Harga Terjangkau</strong> - Kami menawarkan harga yang kompetitif di pasaran.</li>
                <li><strong>Proses Cepat</strong> - Pakaian Anda akan diproses dengan cepat dan efisien.</li>
                <li><strong>Layanan Ramah Pelanggan</strong> - Tim kami siap membantu Anda dengan pelayanan yang ramah dan profesional.</li>
                <li><strong>Pencucian Berkualitas</strong> - Kami menggunakan teknologi dan bahan pembersih terbaik untuk menjaga kualitas pakaian Anda.</li>
            </ul>
        </section>

        <!-- Tombol untuk Menampilkan Daftar Laundry -->
        <section class="view-laundry">
            <h2>Daftar Laundry Terdekat</h2>
            <p>Temukan lokasi laundry terbaik dan terdekat di kota Anda. Klik tombol di bawah untuk melihat daftar laundry.</p>
            <a href="laundry_list.php" class="btn">Lihat Daftar Laundry</a>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Laundry Service</p>
    </footer>
</body>
</html>
