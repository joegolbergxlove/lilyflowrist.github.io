<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Baru - Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <header>
        <h1>Tambah Produk Baru</h1>
    </header>
    <main>
        <form action="proses_tambah.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Produk:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Harga:</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="images">Gambar Produk (bisa pilih lebih dari satu):</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Produk</button>
        </form>
    </main>
</body>
</html>