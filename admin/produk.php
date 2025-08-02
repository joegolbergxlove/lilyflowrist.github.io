<?php
include '../koneksi.php';
$sql = "SELECT * FROM products ORDER BY id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produk - Lily Florist</title>
    <link rel="stylesheet" href="admin_style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="bottom-navbar">
        <h3 class="sidebar-header">Lily Admin</h3>
        <a href="dashboard.php" class="nav-item">
            <span class="icon">📊</span><span class="label">Dashboard</span>
        </a>
        <a href="produk.php" class="nav-item active">
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
                <h2>Manajemen Produk</h2>
                <a href="tambah_produk.php" class="btn btn-primary desktop-add-button">Tambah Produk</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($hasil) > 0) {
                        while ($row = mysqli_fetch_assoc($hasil)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>Rp " . number_format($row['price'], 0, ',', '.') . "</td>";
                            echo "<td>";
                            echo "<a href='edit_produk.php?id=" . $row['id'] . "' class='btn btn-edit'>Edit</a> ";
                            echo "<a href='hapus_produk.php?id=" . $row['id'] . "' class='btn btn-hapus'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Belum ada produk.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <a href="tambah_produk.php" class="fab">+</a>

    <script src="admin_script.js"></script>
    <script>
        const deleteButtons = document.querySelectorAll('.btn-hapus');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const deleteUrl = this.href;
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Produk yang sudah dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    </script>
</body>

</html>