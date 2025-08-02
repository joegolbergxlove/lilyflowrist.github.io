<?php
include '../koneksi.php';

// 1. Hitung Total Produk
$sql_produk = "SELECT COUNT(id) as total_produk FROM products";
$result_produk = mysqli_query($koneksi, $sql_produk);
$data_produk = mysqli_fetch_assoc($result_produk);
$total_produk = $data_produk['total_produk'];

// 2. Hitung Total Pesanan (berdasarkan status)
$sql_pesanan = "SELECT 
                    SUM(CASE WHEN order_status != 'Selesai' THEN 1 ELSE 0 END) as pesanan_berlangsung,
                    SUM(CASE WHEN order_status = 'Selesai' THEN 1 ELSE 0 END) as pesanan_selesai
                FROM orders";
$result_pesanan = mysqli_query($koneksi, $sql_pesanan);
$data_pesanan = mysqli_fetch_assoc($result_pesanan);
$pesanan_berlangsung = $data_pesanan['pesanan_berlangsung'] ?? 0;
$pesanan_selesai = $data_pesanan['pesanan_selesai'] ?? 0;

// 3. Hitung Perkiraan Pemasukan dari pesanan yang sudah 'Selesai'
$sql_pemasukan = "SELECT SUM(total_price) as total_pemasukan FROM orders WHERE order_status = 'Selesai'";
$result_pemasukan = mysqli_query($koneksi, $sql_pemasukan);
$data_pemasukan = mysqli_fetch_assoc($result_pemasukan);
$total_pemasukan = $data_pemasukan['total_pemasukan'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lily Florist</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <nav class="bottom-navbar">
        <h3 class="sidebar-header">Lily Admin</h3>
        <a href="dashboard.php" class="nav-item active">
            <span class="icon">📊</span><span class="label">Dashboard</span>
        </a>
        <a href="produk.php" class="nav-item">
            <span class="icon">📦</span><span class="label">Produk</span>
        </a>
        <a href="pesanan.php" class="nav-item">
            <span class="icon">📋</span><span class="label">Pesanan</span>
        </a>
        <a id="theme-toggle" class="nav-item">
            <span class="icon">🌙</span><span class="label">Tema</span>
        </a>
    </nav>

    <main class="main-content">
        <div class="card">
            <div class="card-header">
                <h2>Overview Bisnis</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-icon">📦</span>
                    <span class="stat-value"><?php echo $total_produk; ?></span>
                    <span class="stat-label">Total Produk</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">🚚</span>
                    <span class="stat-value"><?php echo $pesanan_berlangsung; ?></span>
                    <span class="stat-label">Pesanan Berlangsung</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">✅</span>
                    <span class="stat-value"><?php echo $pesanan_selesai; ?></span>
                    <span class="stat-label">Pesanan Selesai</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">💰</span>
                    <span class="stat-value">Rp <?php echo number_format($total_pemasukan, 0, ',', '.'); ?></span>
                    <span class="stat-label">Total Pemasukan</span>
                </div>
            </div>
        </div>
    </main>

    <script src="admin_script.js"></script>
</body>
</html>