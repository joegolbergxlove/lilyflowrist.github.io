<?php
include '../koneksi.php';
// Query utama untuk mengambil semua pesanan
$sql_orders = "SELECT * FROM orders ORDER BY created_at DESC";
$hasil_orders = mysqli_query($koneksi, $sql_orders);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pesanan - Lily Florist</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <nav class="bottom-navbar">
        <h3 class="sidebar-header">Lily Admin</h3>
        <a href="dashboard.php" class="nav-item"><span class="icon">📊</span><span class="label">Dashboard</span></a>
        <a href="produk.php" class="nav-item"><span class="icon">📦</span><span class="label">Produk</span></a>
        <a href="pesanan.php" class="nav-item active"><span class="icon">📋</span><span class="label">Pesanan</span></a>
        <a id="theme-toggle" class="nav-item"><span class="icon">🌙</span><span class="label">Tema</span></a>
    </nav>

    <main class="main-content">
        <div class="card">
            <div class="card-header">
                <h2>Manajemen Pesanan</h2>
                <a href="tambah_pesanan.php" class="btn btn-primary desktop-add-button">Input Pesanan</a>
            </div>
            
            <div class="order-grid">
                <?php
                if (mysqli_num_rows($hasil_orders) > 0) {
    while ($order = mysqli_fetch_assoc($hasil_orders)) {
        // ... kode untuk mengambil detail dan summary tetap sama ...
        
        // --- TAMBAHKAN LOGIKA INI ---
        // Tambahkan class khusus jika status pesanan 'Selesai'
        $card_class = $order['order_status'] == 'Selesai' ? 'status-selesai' : '';
        
        // --- UBAH BARIS INI ---
        echo '<div class="order-card ' . $card_class . '" data-order-id="' . $order['id'] . '">';
?>
            <div class="card-summary">
                <span class="customer-name"><?php echo htmlspecialchars($order['customer_name']); ?></span>
                <span class="address-tag"><?php echo htmlspecialchars($order['customer_address']); ?></span>
            </div>
            <div class="card-details">
                <p class="detail-summary"><?php /* ... kode summary ... */ ?></p>
                <p class="detail-price">Harga: Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></p>
                <div class="card-actions">
                    <a href="edit_pesanan.php?id=<?php echo $order['id']; ?>" class="btn btn-edit">✏️ Edit</a>
                    
                    <?php if ($order['order_status'] != 'Selesai'): ?>
                        <a href="selesaikan_pesanan.php?id=<?php echo $order['id']; ?>" class="btn btn-hapus" onclick="return confirm('Anda yakin ingin menyelesaikan pesanan ini?')">✅ Selesaikan</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
<?php
    } // Akhir dari while loop
} else {
    echo "<p>Belum ada pesanan.</p>";
}
?>
            </div>
        </div>
    </main>

    <a href="tambah_pesanan.php" class="fab">+</a>

    <script src="admin_script.js"></script>
</body>
</html>